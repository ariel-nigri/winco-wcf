#!/bin/sh
#
# Compress old  log files and move them to YYYY directory
#
mvcompress ()
{
	YEAR=`stat -c '%y' $1 | cut -f1 -d"-"`
	NEWDIR=`dirname $1`/$YEAR
	if [ ! -d $NEWDIR ]; then
		mkdir $NEWDIR
	fi
	mv $1 $NEWDIR
	NEWFILE=$NEWDIR/`basename $1`
	gzip $NEWFILE
}

export -f mvcompress

TODAY=$(date +%s)
BCK_DATE=$((TODAY-90*24*3600))
BCK_DATE_STR=$(date +%Y%m%d -d @$BCK_DATE)

touch -t ${BCK_DATE_STR}0000 /tmp/backup_reference

ls -l /tmp/backup_reference
for DIR in /home/instances/*; do
	echo $LOG_INFO $DIR
	if [ -d  $DIR/var/winco/logs ]; then
	   find $DIR/var/winco/logs -name '*.LOG_*.LOG' ! -newer /tmp/backup_reference -exec bash -c 'mvcompress "$0"' {} \;
	fi
done

