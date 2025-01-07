#!/bin/bash
export VPN_VERSION=$(basename $(pwd))

if [ "$1" = "PRE" ]; then
        ###################### PRE
        # disable SELINUX
        # disable firewalld
        # update system
        yum update
        systemctl disable --now firewalld	
        hostnamectl set-hostname <hostname>
        # this is a problem with rocky9. it seams that the number of services running must fit in this inotify
        # or we have some funny error with "cannot allocate file descriptor"
        echo "fs.inotify.max_user_instances = 1000" > /etc/sysctl.d/99-inotify.conf
        # reboot

        echo "Configure hostname, Email, DNS server and Zabbix NOW and press [enter] to continue."
        ###################### MAIN
        # configure hostname #

        # Configure Email
        # Configure Zabbix
        # Configure DNS (/etc/hosts and hostname)
        read junk

        ##################### WEBADM
        # Install publish public key and give it directory access to /home/instances
        useradd webadm
        mkdir ~webadm/.ssh
        cat > ~webadm/.ssh/authorized_keys <<-'EOF'
                ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABgQCgaRU+QERuFh1iAQCVu2n5DOvXHx9c3eSJ08twsSFFfmcDhXG6ByCYTLymrl8NUU5cvh5G4R2SA5++wfsxcsIs8CpEEWpn86v6teah6vhsn7amFpqnrKLNJMk++QvWJ3bVk3cqT4jKet3Ak8cDpr+8+NPEiqe7eZsyMVVA3uqwm2h6pZYQuDs5Bk6dkv3jUkFkBGOG3GKRkLdSH+G2DsJ12OJjTHMvNR6i+oSDsbxvwPsVC+TvdbedTRRLxXI7J/bi0S2egdzyuB9DUKKbHqDeljoxS8RUWl7efWK1DoLkQ9ASMq4qJtKO0o0kukGATxuLoZqqfyF54UwaJVhPSwQBhLdptBjnkkSWiU4GpPfYVepzzTIOfVLSTwAyB4fiWDJcaSvu65wqf1x/exWrhFjK138j2aTlR2J4nW6GEvXSILpvAh12o6VO3qRhNWntgGyDYN1s3DS4r6IAzi3meJwAxEbhwuVtOL1OhP3mLlwqM4tUL4NcYeTFSGX/nn+xOI8= publish@devel.winco.com.br
EOF
        chown -R webadm:webadm ~webadm/.ssh
        chmod -R go-rwx ~webadm/.ssh
elif [ "$1" = "SYS"]; then
        ##################### PACKAGES
        # Install SYS dependencies and extra repositories
        yum install rsync tar epel-release

        # Install webserver with SSL support
        yum install httpd mod_ssl certbot

        # Install PHP
        yum install php php-json php-pdo php-mbstring php-xml php-mysqlnd

        # ADICIONAR .phtml como extensão válida.

        # Install VPN software dependencies
        yum install libnetfilter_queue libnetfilter_conntrack guacd libguac-client-rdp openvpn easy-rsa

        ##################### OUR SOFTWARE
        # Instances directory
        mkdir -p /home/instances/versions /opt/winco/cloud_framework-vpnd
        chown webadm /home/instances/versions /opt/winco/cloud_framework-vpnd
        # Create /var/lib/wsproxy dir
        mkdir -p /var/lib/winco-wsproxy
        chown apache /var/lib/winco-wsproxy

        echo "Now install the WCF and VPND using syncdiff, and open RDS firewall to our IP address"
        curl checkip.ddns.com.br
fi

# Install wcf
# syncdiff from server

# Install vpn software
# syncdiff from server

if [ "$1" != "WINCO"]; then
        echo "usage: install.sh [SYS|WINCO] will provision this system for cloudvn first run SYS and then WINCO" >&2
        exit 1
fi
####################### WEBSERVER
# Configure webserver
cat > /etc/httpd/conf.d/0-vpnd.conf <<'EOF'
ServerName      %%_SERVER_NAME_%%

define vpnd_cloud_framework     cloud_framework-vpnd
define vpnd_default_version     %%_VPN_VERSION_%%

<Directory /home/instances/versions>
        Require all granted
</Directory>

<Directory /opt/winco/${vpnd_cloud_framework}>
        Require all granted
</Directory>

<Directory /opt/winco/${vpnd_cloud_framework}/pub/console>
        Options +FollowSymLinks
        Require all     granted
        #
        # To limit the people that can access the server, use this
        #
        # SSLVerifyClient require
        # SSLRequire %{SSL_CLIENT_S_DN_CN} in { \
        #         "nigri@winco.com.br", \
        #         "marcelo.diamand@winco.com.br", \
        #         "alexandre@winco.com.br", \
        #         "leandro@winco.com.br", \
        #         "luis.felipe@winco.com.br", \
        #         "driely.silva@winco.com.br", \
        #         "danilo.almeida@winco.com.br", \
        #         "alex.monteiro@winco.com.br", \
        #         "angelica.zanatta@winco.com.br", \
        #         "daniel.freitas@winco.com.br", \
        #         "eduardo.reyes@winco.com.br", \
        #         "ian.victor@winco.com.br" \
        #}
        # when using CERT, pass the username
        SSLUserName SSL_CLIENT_S_DN_CN
</Directory>

<VirtualHost _default_:80>
        RewriteEngine   on

        TransferLog     logs/vpnd-transfer_log
        ErrorLog        logs/vpnd-error_log

        RewriteRule     ^/(\.well\-known)/(.*)          /var/www/html/$1/$2                                             [L]
        RewriteRule     ^/$                             https://%{HTTP_HOST}/${vpnd_default_version}/admin/             [R,L]
        RewriteRule     ^/?lang=(.+)$                   https://%{HTTP_HOST}/${vpnd_default_version}/admin/?lang=$1     [R,L]
        RewriteRule     ^/(.*)                          https://%{HTTP_HOST}/$1                                         [L,R]
</VirtualHost>

<VirtualHost _default_:443>
        ServerName      %%_SERVER_NAME_%%
        ServerAlias     *.connectas.net

        SSLEngine       on
        RewriteEngine   on

        SSLCertificateFile      /etc/letsencrypt/live/%%_SERVER_NAME_%%/cert.pem
        SSLCertificateKeyFile   /etc/letsencrypt/live/%%_SERVER_NAME_%%/privkey.pem
        SSLCertificateChainFile /etc/letsencrypt/live/%%_SERVER_NAME_%%/chain.pem
        SSLCACertificateFile    /etc/pki/tls/certs/ca.winco.com.br.crt

        Options +FollowSymLinks
        TransferLog     logs/%%_SERVER_NAME_%%-transfer_log
        ErrorLog        logs/%%_SERVER_NAME_%%-error_log
        LogFormat       "%h %l %{X-Logged-User}o %t \"%r\" %>s %b"

        DirectoryIndex  dashboard.phtml index.phtml index.php
        DocumentRoot    /opt/winco/${vpnd_cloud_framework}/pub/

        RewriteRule     ^/$                             https://%{HTTP_HOST}/${vpnd_default_version}/admin/     [R,L]
        RewriteRule     ^/vpn([0-9]+)/(.*)              /home/instances/versions/vpn$1/pub/$2                   [L]
        RewriteRule     ^/wss/([^/]+)/([^/]+)/(.+)	ws://0xac$1:9090/$2/?token=$3		[P,L,QSA]

        RewriteCond %{HTTP_HOST}	^(.+)-([hHsS][0-9]*)-([0-9a-fA-F]{6})\.connectas\.net$
        RewriteCond %{HTTP_HOST}	^(.+)-([hHsS][0-9]*)-([0-9a-fA-F]{6})\.connectas\.net$
        RewriteRule ^/(.*)$		http://0xac%3:9090/http/%1-%2/$1 	[P,L]
#       For debuging, we redirect to local host.
#        RewriteRule ^/(.*)$		http://0x7f%3:9090/http/%1-%2/$1 	[P,L]

        AddType         application/x-openvpn-profile   .ovpn
</VirtualHost>
EOF

# Now replace the variables
sed -i -e "s/%%_SERVER_NAME_%%/$(hostname)/"  -e "s/%%_VPN_VERSION_%%/${VPN_VERSION}/" /etc/httpd/conf.d/0-vpnd.conf

# make sure the ssl config is the one we need.
mv /etc/httpd/conf.d/ssl.conf /etc/httpd/conf.d/ssl.conf.original

# Now the new SSL config file
cat > /etc/httpd/conf.d/ssl.conf <<'EOF'
Listen 443 https

SSLPassPhraseDialog exec:/usr/libexec/httpd-ssl-pass-dialog

SSLSessionCache         shmcb:/run/httpd/sslcache(512000)
SSLSessionCacheTimeout  300

SSLRandomSeed startup file:/dev/urandom  256
SSLRandomSeed connect builtin

SSLCryptoDevice builtin

SSLProtocol all -SSLv2 -SSLv3
SSLCipherSuite HIGH:3DES:!aNULL:!MD5:!SEED:!IDEA

EOF

#################################### SSL CERTIFICATES
# time to issue the certificate. The first one will be issued using a temporary webserver
# - SSL certificate, Winco CA
cat > /etc/pki/tls/certs/ca.winco.com.br.crt <<'EOF'
-----BEGIN CERTIFICATE-----
MIIDTTCCAjWgAwIBAgIJAPgrHfouPRF4MA0GCSqGSIb3DQEBCwUAMB4xHDAaBgNV
BAMTE1dpbmNvIFRlY25vbG9naWEgQ0EwHhcNMTUwMzI3MTY1NTA5WhcNMjUwMzI0
MTY1NTA5WjAeMRwwGgYDVQQDExNXaW5jbyBUZWNub2xvZ2lhIENBMIIBIjANBgkq
hkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAspX6K+7W4w+v59370HmAOP2YSz1iv8d9
qywOC4KCEj+M31t5TnHpG94AS1VFiT0raZXfg65nd6xHL37pzuIo3j2ElLDNEQP9
D3EskNrvrWkdijjytC8CqTD8DAsmNHxUScb4K8twD3c6ApHMEOPXT6YBXB3NTg6z
wbcGkCTjKS33w8TOXnzAmUMWbFYYCdSbpE3hou7U/eSVWRjHfK8LjF82XiCP6uBW
8v0JfijzQI83OEwRyjSqwVJ5edcK8hGOSIPIZG3cK8zGMtbfur0xWpo9uDPY9GPh
zZfKAX2bRKTukBAPz5TlKHWrzilp2S7JsrvjJYNHJPXXNZLchnvtXwIDAQABo4GN
MIGKMB0GA1UdDgQWBBTLdpozJdQanUdtJ40BPH9wFCC8GTBOBgNVHSMERzBFgBTL
dpozJdQanUdtJ40BPH9wFCC8GaEipCAwHjEcMBoGA1UEAxMTV2luY28gVGVjbm9s
b2dpYSBDQYIJAPgrHfouPRF4MAwGA1UdEwQFMAMBAf8wCwYDVR0PBAQDAgEGMA0G
CSqGSIb3DQEBCwUAA4IBAQCZi7KN+oI6LM+e8r0ulPEjd2g6I+80jiapjIBE1SaZ
+cWdTwIDAcFpTTqH5xERZ4DNkzZR6XI6aN9qkOTfrwE3h9636cFoMUfsbNcY3ltw
5R2Pof5Nf1hSJM8c1VvbcWSqBeu/ThJWcXXHP50P7Pct6WKea40Gp1+mpv8JK6O/
GgUfbELP81hZnOyynGTtoBno/hAWCQmjmJMPYMgo0nFdHW/agSNOAPt2DZ8Gg1LC
c7v57VDfDoUWPJQ20urVtqZIBLJ14dXeNQIT5Kbl15AdMZNAP+xOpr32E7fCKE1c
hZUQPLH/9jx4+UOziuklTsmdMy8ZYv87yaWvB3p84OrZ
-----END CERTIFICATE-----
EOF

systemctl stop httpd
certbot certonly --standalone -d $(hostname)
systemctl start httpd

# Now, the certificate used by Winco VPN
cat /etc/letsencrypt/live/$(hostname)/fullchain.pem  >/etc/pki/tls/certs/vpnd.winco.com.br.pem
cat /etc/letsencrypt/live/$(hostname)/privkey.pem    >> /etc/pki/tls/certs/vpnd.winco.com.br.pem

#################################### SYSTEM ENVIRONMENT
# time to issue the certificate. The first one will be issued using a temporary webserver
# - SSL certificate, Winco CA
cat > /etc/sudoers.d/1-vpnd <<'EOF'
Defaults:apache   ! requiretty

Defaults env_keep += "product_code"

apache      ALL = (ALL) NOPASSWD: /opt/winco/cloud_framework-*/utils/inst-ctl,/bin/systemctl
apache      ALL = (ALL) NOPASSWD: /home/instances/versions/*/util/create_instance.sh, /home/instances/versions/*/util/service_config, /home/instances/versions/*/util/delete_instance.sh, /etc/init.d/vpnd-*, /home/instances/versions/*/util/openvpn-fix-stat
EOF

cat > /etc/sudoers.d/2-openvpn <<'EOF'
apache ALL=(ALL) NOPASSWD:/usr/share/easy-rsa/3/easyrsa
EOF

# Configure bash profile
cat > /etc/profile.d/wcf.sh <<'EOF'
# cloud framework path

if [ -f /opt/winco/cloud_framework-vpnd/config/current_version_VPND.cfg ]; then
        curr_ver=$(cat /opt/winco/cloud_framework-vpnd/config/current_version_VPND.cfg)
        PATH=${PATH}:/opt/winco/cloud_framework-vpnd/utils:/home/instances/versions/${curr_ver}/util
fi
EOF

#################################### CONFIGURATION FOR OWN OWN SOFTWARE
# WCF
mkdir -p /opt/winco/cloud_framework-vpnd/config
cat > /opt/winco/cloud_framework-vpnd/config/install_params.php <<'EOF'
<?php

date_default_timezone_set('America/Sao_Paulo');

define('CFM_DEFAULT_LANGUAGE', 'br');

$product_code = 'VPND';

$framework_dir = dirname(__DIR__);
require "install_params_{$product_code}.php";
EOF

cat > /opt/winco/cloud_framework-vpnd/config/install_params_VPND.php <<'EOF'
<?php

$usr_passwd_salt = 'XXX_123_124';
$adm_passwd_salt = 'XXX_123_124';

$product_name = 'ConnectasCloud';

$console_caps = array(
        'LICENSES' => false,
);

$db_dsn = 'mysql:host=rds-mysql;dbname=vpnd;';
$db_user = "vpnd";
$db_passwd = '<password_here>';

$instance_classname = 'VPND_Instances';
$my_worker_names = [ gethostname() ];

$default_license = "NO_LICENSE_REQUIRED_FOR_VPND";

$lic_type = array();
$binname = 'vpnd.';

$vpnd_access_token = '<put access token here>';

// password complexity: minimum of 8 chars, 1 upper, 1 lower and 1 number.
//$users_pwd_complexity_regex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/';

$vpnd_renewal_from_email = 'operacao@winco.com.br';
$vpnd_renewal_from_name = 'Connectas.cloud';
$vpnd_renewal_email_bcc = 'comercial@winco.com.br';
EOF

echo ${VPN_VERSION} > /opt/winco/cloud_framework-vpnd/config/current_version_VPND.cfg

# systemctl link
ln -s /opt/winco/cloud_framework-vpnd/utils/wcf@.service /etc/systemd/system
systemctl daemon-reload

# Configure VPND?
cat > /home/instances/versions/${VPN_VERSION}/config/install_params.php <<'EOF'
<?php

$base_domain            = '%%_SERVER_DOMAIN_%%';
$login_mode             = 'cloud';
$admin_start_path       = '/admin/';
$framework_dir          = '/opt/winco/cloud_framework-vpnd';
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

sed -i -e "s/%%_SERVER_DOMAIN_%%/$(hostname -d)/" /home/instances/versions/${VPN_VERSION}/config/install_params.php

#
# Configure certbot and the reload scripts.
# TODO
