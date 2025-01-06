#!/bin/bash

create_vpn_config() {
	# Configure VPND?
	cat > ${versions_dir}/${vpn_version}/config/install_params.php <<'EOF'
<?php

$base_domain            = '${base_domain}';
$login_mode             = 'cloud';
$admin_start_path       = '/admin/';
$framework_dir          = '${wcf_dir}';
$current_version        = basename(dirname(__DIR__));
$store_base_url         = 'https://cloudvpn.winco.com.br/buy_vpn';

/*
CONNECTION TO SISVENDAS ($store_base_url):

Parameters (all sent by GET):
        email: users e-mail.
        opt: operation type. (N) for new license, (U) for upgrade.
        lic: previous license. Mandatory for (U)
*/
EOF
}

create_wcf_config() {
	sed ${sed_edit} VPND_install_params.php-template > ${wcf_dir}/config/install_params.php
	echo ${vpn_version} > ${wcf_dir}/config/current_version_VPND.cfg
}

db_install() {
	# Database installation
	if ! rpm -q mysql-server; then
		echo "Mysql server not installed. Please enter admin password to install it"
		sudo dnf install mysql-server
		sudo systemctl enable --now mysqld
	fi

	if sudo mysql -e "CREATE DATABASE ${db_name};";  then
		sudo mysql ${db_name} < ${wcf_dir}/common/bizobj/VPND_schema.sql

		echo "CREATE USER '${db_user}' IDENTIFIED BY '${db_pass}'; GRANT SELECT, INSERT, DELETE, UPDATE ON connectas.* TO '${db_user}'; FLUSH privileges; " \
		| sudo mysql ${db_name}

		./usu-ctl regadmin Admin ${admin_user} ${admin_pass}
	fi
}

app_config() {
	# create the webserver configuration
	eval sed ${sed_edit} VPND_httpd.conf-template > /etc/httpd/conf.d/1-connectas.conf

	# create the sudoers e profile configuration
	eval sed ${sed_edit} VPND_sudoers-template > /etc/sudoers.d/connectas-sudoers

	# cloud framework path
	cat > /etc/profile.d/wcf.sh <<EOF
if [ -f ${wcf_dir}/config/current_version_VPND.cfg ]; then
    curr_ver=\$(cat ${wcf_dir}/config/current_version_VPND.cfg)
    PATH=\${PATH}:${wcf_dir}/utils:${versions_dir}/\${curr_ver}/util
fi
EOF
}

if [ -z $1 ]; then
	echo "usage: configure.sh <params_file>" >&2 
	exit 1
fi

#
# Get the my_host and base_domain vars.
#
my_host=$(hostname -s)
base_domain=$(hostname | cut -d. -f2-)

if [ -z $base_domain ] || [ $base_domain = localdomain ]; then
	echo "You must set the domain name to a complete FQDN"
	exit 1
fi

. $1

#
# Calculate the set "edit command" necessary to create the config files.
#
sed_edit=
for var in wcf_dir versions_dir base_domain my_host cert_file key_file chain_file; do
	[ -z $$var ] && continue
	eval "val=\$${var}"
	sed_edit="${sed_edit} -e's|%%${var}%%|${val}|'"
done

create_vpn_config
create_wcf_config
if [ $create_db = yes ]; then
	db_install
fi
app_config