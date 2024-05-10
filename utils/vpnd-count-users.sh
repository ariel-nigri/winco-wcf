#!/bin/bash

inst-query inst_seq inst_type | cut -d, -f1 > /tmp/users_instances.txt

while read inst users; do
	num_ovpn=$(ls $inst/var/pki/issued | wc -l)
	num_ovpn=$((num_ovpn-1))
	num_wvpn=$(ls $inst/var/winco/regdb/HKEY_LOCAL_MACHINE/Winconnection/cfgX/USERDB/USERS | wc -l)
	num_wvpn=$((num_wvpn-2))
	echo -e "${inst}\t  ${users}\t${num_ovpn}\t${num_wvpn}"
done < /tmp/users_instances.txt
rm /tmp/users_instances.txt

