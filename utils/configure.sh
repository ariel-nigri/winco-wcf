#!/bin/bash

- machine checkup
	- instalar pacotes
	- checar SELinux
	- deligar firewall
	- criar extensao phtml e wsvc no httpd
	- permitir extensao phtml e wsvc no php-fpm

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