#!/bin/bash

check_system() {
	echo "fs.inotify.max_user_instances = 2000" > /etc/sysctl.d/99-inotify.conf
	if [ $(getenforce) != Disabled ]; then
		echo "O sistema SELinux deve ser desativado e o sistema reiniciado. "
		echo "Para terminar a configuração execute este programa novamente após o reinício. "
		echo "Aperte <ENTER> para desativar o SELinux e reiniciar"
		read junk
		sed -i -e's/^SELINUX=.*$/SELINUX=disabled/' /etc/selinux/config
		reboot
	fi
	systemctl disable --now firewalld 2> /dev/null
	systemctl enable --now httpd php-fpm
}

create_vpn_config() {
	# Now, the certificate used by Winco VPN
	cat ${cert_file}  >  /etc/pki/tls/certs/vpnd.winco.com.br.pem
	cat ${chain_file} >> /etc/pki/tls/certs/vpnd.winco.com.br.pem
	cat ${key_file}   >> /etc/pki/tls/certs/vpnd.winco.com.br.pem

	# Configure VPND?
	cat > ${versions_dir}/${vpn_version}/config/install_params.php <<EOF
<?php

\$base_domain            = '${base_domain}';
\$login_mode             = 'cloud';
\$admin_start_path       = '/admin/';
\$framework_dir          = '${wcf_dir}';
\$current_version        = basename(dirname(__DIR__));
\$store_base_url         = 'https://cloudvpn.winco.com.br/buy_vpn';

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
	mkdir -p ${wcf_dir}/config
	eval sed ${sed_edit} VPND_templates/wcf_install_params.php-template > ${wcf_dir}/config/install_params.php
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

		# register ourselves as a worker
		echo "INSERT INTO workers (worker_hostname, worker_frontend, worker_ip, worker_active) VALUES('${my_host}.${base_domain}', '${my_host}.${base_domain}', '127.0.0.1', 1);" \
		| sudo mysql ${db_name}

	fi
}

make_readable() {
	echo "Alterando as permissoes do diretorio $1 para ser acessivel pelo apache. (o+rx)"
	echo "Depois verifique isso quanto a segurança"
	dir=$1
	while [ ! -z $dir ] && [ $dir != '/' ]; do
		chmod go+rx $dir
		dir=$(dirname $dir)
	done
}

app_config() {
	# create the webserver configuration
	eval sed ${sed_edit} VPND_templates/httpd_connectas.conf-template > /etc/httpd/conf.d/1-connectas.conf

	# Improve and simplify SSL security
	if [ ! -f /etc/httpd/conf.d/ssl-orig.conf-disabled ]; then
		mv /etc/httpd/conf.d/ssl.conf /etc/httpd/conf.d/ssl-orig.conf-disabled
		cp VPND_templates/httpd_ssl.conf-template /etc/httpd/conf.d/ssl.conf
	fi

	# create the sudoers configuration
	eval sed ${sed_edit} VPND_templates/sudoers-template > /etc/sudoers.d/connectas-sudoers

	# create profile.d (path) config
	cat > /etc/profile.d/wcf.sh <<EOF
if [ -f ${wcf_dir}/config/current_version_VPND.cfg ]; then
    curr_ver=\$(cat ${wcf_dir}/config/current_version_VPND.cfg)
    PATH=\${PATH}:${wcf_dir}/utils:${versions_dir}/\${curr_ver}/util
fi
EOF
	# create systemd service
	eval sed ${sed_edit} VPND_templates/wcf@.service-template > /etc/systemd/system/wcf@.service

	# make sure the web acessible directories are readable by others
	sudo -u apache ls ${wcf_dir}      > /dev/null 2>&1  || make_readable ${wcf_dir}
	sudo -u apache ls ${versions_dir} > /dev/null 2>&1  || make_readable ${versions_dir}

	systemctl daemon-reload
	systemctl reload httpd php-fpm
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
# this command will replace all values denoted by %%var%% with the value of $var,
# provided the var is one of the variables in the for
#
sed_edit=
for var in wcf_dir versions_dir base_domain my_host cert_file key_file chain_file db_host db_name db_user db_pass; do
	[ -z $$var ] && continue
	eval "val=\$${var}"
	sed_edit="${sed_edit} -e's|%%${var}%%|${val}|g'"
done

check_system
create_vpn_config
create_wcf_config
if [ $create_db = yes ]; then
	db_install
fi
app_config
