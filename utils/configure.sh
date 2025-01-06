#!/bin/bash

- machine checkup
	- instalar pacotes
	    - devel
		dnf install epel-release gcc-c++ sqlite-devel openldap-devel
		dnf --enablerepo=crb install ccache libcap-devel libunwind-devel libnfnetlink-devel libnetfilter_conntrack-devel libnetfilter_queue-devel libmnl-devel		

		- prod

        dnf install rsync tar epel-release httpd mod_ssl certbot php php-json php-pdo php-mbstring php-xml php-mysqlnd
        # Install VPN software dependencies
        dnf install libnetfilter_queue libnetfilter_conntrack guacd libguac-client-rdp openvpn easy-rsa




		dnf install gcc-c++ ccache openldap-devel sqlite-devel libcap-devel libunwind-devel openssl-devel \
			libssh2-devel npm
		dnf --enablerepo=crb install libnfnetlink-devel libnetfilter_conntrack-devel libnetfilter_queue-devel libmnl-devel
	- checar SELinux
		if [ $(getenforce) != Disabled ]; then
			sed -i -e's/^SELINUX=.*$/SELINUX=disabled/' /etc/selinux/config
			reboot
		fi
	- definir um hostname;

	- deligar firewall
		systemctl disable --now firewalld
	- criar extensao phtml e wsvc no httpd
		/etc/httpd/conf.d/php.conf
	- permitir extensao phtml e wsvc no php-fpm
		/etc/php-fpm.d/www.conf
	- inciar servidor web e php
	    systemctl enable --now httpd php-fpm


Clone wcf

Verify databse

Configure wcf

Clone vpn

Configure vpn

- Database checkup
	- create database user
	- create the database.
	- create the admin user.

- application setup
	- create the webserver configuration
	- create the sudoers e profile configuration
	- configure application with backlink to wcf?

# variaveis a serem definidas antes de configurar.
define wcf_dir     		%%wcf_dir%%
define versions_dir		%%versions_dir%%
define base_domain		%%base_domain%%
define my_host			%%my_host%%
define cert_file		%%cert_file%%
define key_file			%%key_file%%
define chain_file		%%chain_file%%

# cloud framework path
# if [ -f /opt/winco/cloud_framework-vpnd/config/current_version_VPND.cfg ]; then
#        curr_ver=$(cat /opt/winco/cloud_framework-vpnd/config/current_version_VPND.cfg)
#        PATH=${PATH}:/opt/winco/cloud_framework-vpnd/utils:/home/instances/versions/${curr_ver}/util
# fi
