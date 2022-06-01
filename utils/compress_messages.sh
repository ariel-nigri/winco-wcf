#!/bin/bash
#
# Compress old  message  files and move them to YYYY directory
#
mvcompress ()
{
	if [[ $1 != *.gz ]] ; then		#Skip files already gziped 
		YEAR=`stat -c '%y' $1 | cut -f1 -d"-"`
		MONTH=`stat -c '%y' $1 | cut -f2 -d"-"`
		MSGDIR=`dirname $1`/messages
		if [ ! -d $MSGDIR ]; then
			mkdir $MSGDIR
		fi
		NEWDIR=$MSGDIR/$YEAR-$MONTH
		if [ ! -d $NEWDIR ]; then
			mkdir $NEWDIR
		fi
		mv $1 $NEWDIR
		NEWFILE=$NEWDIR/`basename $1`
		gzip $NEWFILE
	fi
}

export -f mvcompress

TODAY=$(date +%s)
COMPRESS_DATE=$((TODAY-30*24*3600))
COMPRESS_DATE_STR=$(date +%Y%m%d -d @$COMPRESS_DATE)

touch -t ${COMPRESS_DATE_STR}0000 /tmp/compress_reference

for DIR in /home/instances/*; do
	echo $DIR
	if [ -d  $DIR/var/winco/dat ]; then
	   find $DIR/var/winco/dat -regextype posix-extended -regex '.*/[0-9]{4}-[0-9]{2}-[0-9]{2}-messages-.*' ! -newer /tmp/compress_reference -exec bash -c 'mvcompress "$0"' {} \;
	fi
done

