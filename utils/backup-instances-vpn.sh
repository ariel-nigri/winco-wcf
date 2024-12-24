#!/bin/bash -e

if [ "$1" != "run" ]; then
	cat >&2 <<EOF
usage: $0 run

  This script will backup the all the instances of VPN in this host as follows:

  - If anything changed in the configuration (regdb and openvpn certs/config),
	it will create a new config tar and upload it to s3.
  - If there are logs older than 30 days in var/winco/logs, it will compress them
    and archive in the S3 storage.
  - Everything else (live config, fresh log) will be rsync'd to the mirror worker

EOF
	exit 1
fi

mydir=$(dirname $(realpath $0))
cd $mydir

. ../config/mirror_params.sh

inst_list=$(./inst-query -q worker_frontend=$(hostname) inst_seq)
inst_list="${inst_list} $(./inst-query -q worker_frontend=vpnd-02.winco.com.br inst_seq)"
# What to backup
CONFIG_DIRS="etc var/pki var/winco/regdb/ var/vars"

# What is the reference date for the backup and removal old logfiles.
BCK_DATE=$(($(date +%s)-30*24*3600))
BCK_DATE_STR=$(date +%Y%m%d -d @$BCK_DATE)
touch -t ${BCK_DATE_STR}0000 /tmp/backup_reference

if [ -z "$inst_list" ]; then
	echo "WARNING: no instances configured in host $(hostname)" >& 2
	exit 1
fi

# Function to find out if we need to do a backup of the configuration
need_backup_config() {
	if [ ! -f var/winco/backup/backup_reference ]; then
		newer_files=yes
	else
		# make sure the reference date is what is written in the file itself.
		dtref=$(cat var/winco/backup/backup_reference)
		touch -t $dtref var/winco/backup/backup_reference

		newer_files=$(find $* -newer var/winco/backup/backup_reference -print 2>/dev/null)
	fi
	if [ -z "$newer_files" ]; then
		return 1
	fi
	return 0
}

# Function to return if this is the only run today for this instance
once_a_day() {
	typeset -i lastbackup=0

	[ -f var/winco/logs/LAST_BACKUP ] && lastbackup=$(cat var/winco/logs/LAST_BACKUP)
	[ $lastbackup -lt $(date +%Y%m%d) ] && return 0
	return 1
}

# Compress old  log files and move them to YYYY directory
mvcompress () {
	YEAR=`stat -c '%y' $1 | cut -f1 -d"-"`
	NEWDIR=`dirname $1`/$YEAR
	if [ ! -d $NEWDIR ]; then
		mkdir $NEWDIR
	fi
	mv $1 $NEWDIR
	NEWFILE=$NEWDIR/`basename $1`
	gzip $NEWFILE
}

# Main function to compress log files
compress_logs() {
	export -f mvcompress

	find var/winco/logs -name '*.LOG_*.LOG' ! -newer /tmp/backup_reference -exec bash -c 'mvcompress "$0"' {} \;
}

echo "==== Backing up everything ===="
for inst in $inst_list; do
	echo "-> Backing up ${inst}"
	if [ ! -d /home/instances/${inst}/var/winco ]; then
		echo "Directory structure for instance ${inst} is not there" >& 2
		continue
	fi

	# first we manage the configurations
	pushd /home/instances/${inst}

	# Backup dir will be used a lot
	backup_dir=var/winco/backup

	if need_backup_config $CONFIG_DIRS; then
		echo "Needs to backup instance $inst"

		mkdir -p ${backup_dir}

		# we will mark one second behind to catch racing conditions (too much, but..)
		timestamp=$(($(date +%s)-1))

		# Do the backup to the temp file and upload it
		rm -f ${backup_dir}/${inst}-config-tmp.tgz
		tar czf ${backup_dir}/${inst}-config-tmp.tgz $CONFIG_DIRS
		new_config=${inst}-config-$(date +%Y%m%d_%H%M%S -d @${timestamp})

		# All went well. Rename the local file and touch the reference
		# file with the start date of the backup
		mv -f ${backup_dir}/${inst}-config-tmp.tgz ${backup_dir}/${new_config}.tgz
		rm -f ${backup_dir}/backup_synced
		echo $(date +%Y%m%d%H%M.%S -d @$timestamp) > ${backup_dir}/backup_reference 

		# there isn't a send queue and this is bad. the script above should keep track of what works and what doesnt

		# Lastly we do the live backup of the current config
		rsync -a --delete var etc --exclude 'var/winco/logs/20??/' ${mirror_worker}:/home/instances/${inst}/
	else
		# No config changes, so sync only the logs and the ipp.txt file
		echo "No changes in the config of instance $inst"
		[ -f var/ipp.txt ] && ipp=var/ipp.txt || ipp=''
		rsync -a --delete -R ${ipp} var/winco/logs --exclude 'var/winco/logs/20??/' ${mirror_worker}:/home/instances/${inst}/
	fi

	# backup to s3 will also delete very old config files in the disk and in the AWS EC2 system
	if [ ! -f ${backup_dir}/backup_synced ]; then
		${mydir}/backup-config-to-s3 $inst && touch ${backup_dir}/backup_synced
	fi

	# Now we manage the log files, but only once a DAY
	if once_a_day $inst; then
		# echo "==== Once a day RUN ===="
		compress_logs
		${mydir}/backup-log-files	$inst
		echo $(date +%Y%m%d) > var/winco/logs/LAST_BACKUP
	fi
	popd
done
