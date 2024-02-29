#!/bin/bash

#
# /home/instances (--delete)
# /etc/letsencrypt
# /etc/httpd/conf.d
# /etc/sudoers.d/wcf
# /opt/winco (-config?)
# /etc/pki/tls/certs/*.pem
# /etc/profile.d/wcf.sh
# /etc/systemd/system/wcf@.service
# create the instances lv (only dir with --delete)
#
export PATH=${PATH}:/usr/sbin
if [ $0 == '-bash' ]; then
	mydir=$(pwd)
else
	mydir=$(dirname $(realpath -- $0))
fi

. ${mydir}/snapshot-utils.sh
. $(dirname ${mydir})/config/mirror_params.sh

# Mirror the instances using the LVM support for snapshots
mirror_instances() {
	snap_create_id ${instances_lv} backup1
	(
		cd ${instances_mount}
		rsync -av --delete * ${mirror_worker}:/home/instances/
	)
	snap_remove backup1
}

# Mirror cloud_framework changes
mirror_wcf() {
	(
		cd /opt/winco/cloud_framework-vpnd
		rsync -av * --exclude config          ${mirror_worker}:/opt/winco/cloud_framework-vpnd/
		cd /etc/profile.d/
		rsync -av /etc/profile.d/wcf.sh	      ${mirror_worker}:/etc/profile.d/
		rsync -av /etc/sudoers.d/*            ${mirror_worker}:/etc/sudoers.d/
	)
}

# Mirror miscelaneous config files
mirror_config() {
	rsync -av /etc/letsencrypt                ${mirror_worker}:/etc/
	rsync -av /etc/pki/tls/certs/*.pem        ${mirror_worker}:/etc/pki/tls/certs/
	rsync -av /etc/httpd/conf.d/*-vpnd.conf   ${mirror_worker}:/etc/httpd/conf.d/
}

if [ "$1" = run ]; then
	mirror_instances
	mirror_wcf
	mirror_config
elif [ ! -z $1 ]; then
	$1
fi
