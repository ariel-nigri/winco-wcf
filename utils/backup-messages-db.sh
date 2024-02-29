#!/bin/bash
#
# Compress old  message  files and move them to YYYY directory
#
mvcompress () {
	backupdir=messages/$(echo $2 | cut -c1-7)
	# echo backup $2 to $1/${backupdir}
	if [ ! -d $1/${backupdir} ]; then
		echo "  => mkdir $1/${backupdir}"
		mkdir -p $1/${backupdir}
	fi
	mv $1/$2 $1/${backupdir} && gzip $1/${backupdir}/$2
}

TODAY=$(date +%s)
COMPRESS_DATE=$((TODAY-26*3600))
COMPRESS_DATE_STR=$(date +%Y%m%d -d @$COMPRESS_DATE)

touch -t ${COMPRESS_DATE_STR}0000 /tmp/compress_reference

for DIR in /home/instances/*/var/winco/dat; do
	echo $DIR
	(cd $DIR; ls) | \
		while read file; do
			[[ ${file} = 20??-??-??-messages-* ]] && [ /tmp/compress_reference -nt ${DIR}/${file} ] && mvcompress ${DIR} ${file}
		done
done

#
# Run the backup job for all instances that have files.
#
cd /home/instances

for i in *; do
	if [ -d $i/var/winco/dat ]; then
		/opt/winco/cloud_framework-php7/utils/backup-instance -v -d -m $i
	fi
done
