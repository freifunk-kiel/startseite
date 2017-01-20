# Images created by Moorviper

These images are free images. source: https://github.com/Moorviper/Freifunk-Router-Anleitungen/wiki

downloaded and resized with

```
git clone https://github.com/Moorviper/Freifunk-Router-Anleitungen
cd Freifunk-Router-Anleitungen/
mkdir fronts
for i in *-*; do cd $i; for f in *front*.jpg; do echo "$f";done; cd ../fronts/; ln -s ../$i/$f $i.jpg;cd ..;done
cd fronts/
for i in *.jpg; do
new="$(basename $i .jpg \
| sed -e 's/\.\(img\|vdi\|vmdk\)$//g' \
| sed -E 's/-v[0-9\.]+$//')_100x60.png"
#echo $new; done
touch $new
convert $i -resize 100x60 $new
done

convert  tp-link-tl-wr841n-nd-v11.jpg -resize 100x60 tp-link-tl-wr841n-nd_100x60.png
rm tp-link-tl-wr703n_100x60.png
touch tp-link-tl-wr703n_100x60.png
rm tp-link-tl-wr2543n-nd_100x60.png
touch tp-link-tl-wr2543n-nd_100x60.png

mkdir large
mv *jpg large/

mv fronts/* /var/www/freifunk/ffki-startseite/images/models/
```

Point the Webserver to this directory.
For Apache add these lines:
```
	#Router Node Pictures
	Alias /images/models/ /opt/hardware/Freifunk-Router-Anleitungen/router/fronts/
	<Directory /opt/hardware/Freifunk-Router-Anleitungen/router/fronts/>
		Options Indexes FollowSymLinks MultiViews
		AllowOverride All
		Require all granted
		ExpiresByType image/png "access plus 1 week"
		ExpiresByType image/jpeg "access plus 1 week"
	</Directory>
```
to the ffki-startseite config.
