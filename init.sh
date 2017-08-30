#!/bin/bash
set -e
set -u
#
# Creates non-versioned directories and sets all possible permissions.
#


BasePath=$(dirname "$0")

Umask=$(umask)
read -p "Umask [$Umask]: " Umask foo
[ -n "$Umask" ] && umask $Umask


UseAcl=
read -n 1 -p 'Use ACL [Y/n]? ' key
echo
if [ -z "$key" -o "$key" = 'y' -o "$key" = 'Y' ]; then
	UseAcl=1
	AclUser='www-data'
	read -p "ACL User [$AclUser]: " tmp foo
	[ -n "$tmp" ] && AclUser=$tmp

	AclUser2=$(whoami)
	read -n 1 -p "Set defaults ACL for $AclUser2 [Y/n]? " key
	echo
	[ -n "$key" -a "$key" != '-y' -a "$key" != '-Y' ] && AclUser2=
else
	Mode='777'
	read -p "Mode [$Mode]: " tmp foo
	[ -n "$tmp" ] && Mode=$tmp
fi


for d in lib temp log sessions; do
	mkdir -p "$BasePath"/"$d"
	if [ "$UseAcl" ]; then
		setfacl -R -m "u:$AclUser:rwx" "$d"
		setfacl -R -m "d:u:$AclUser:rwx" "$d"
		[ -n "$AclUser2" ] && setfacl -R -m "d:u:$AclUser2:rwx" "$d"
	else
		chmod -R $Mode "$d"
	fi
done

echo 'done'
