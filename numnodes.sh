#!/bin/bash
# reads all online nodes and creates an HTML page from the template numnodes.template

#echo -n "online nodes: "
num=$(wget http://127.0.0.1:4000/metrics -qO - | grep meshnodes_online_total|cut -d ' ' -f2) 2> /dev/null

if test "$num" -ge 1; then

	num="$(expr $num - 4)"
	cd "$(dirname "$0")"

	sed 's/<NUM_NODES>/'"$num"'/g' numnodes.template > _site/numnodes.html

fi	
