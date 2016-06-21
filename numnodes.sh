#!/bin/bash
# reads all online nodes and creates an HTML page from the template numnodes.template
JSON=/opt/ffmap-backend-neu/json/nodes.json
#wget http://map.freifunk.in-kiel.de/json/nodes.json -qO $JSON

#echo -n "online nodes: "
num="$(cat $JSON | jq '.nodes[] | select(.flags.gateway==false) | select(.flags.online==true)' | grep -c online)" 2> /dev/null

if test "$num" -ge 1; then

	num="$(expr $num - 4)"
	cd "$(dirname "$0")"

	sed 's/<NUM_NODES>/'"$num"'/g' numnodes.template > _site/numnodes.html

else

	cp "$JSON" "$JSON.defekt"
	BAK="$(find /opt/ffmap-backend-neu/json -name 'nodes.json.bak*' -printf '%T+\t%p\n' | sort -r | head -n1 | cut -f2)"
	cp "$BAK" "$JSON"

fi	

#echo -n "offline nodes: "
#cat $JSON |jq '.nodes[] | select(.flags.gateway==false) | select(.flags.online==false)'|grep online|wc -l
