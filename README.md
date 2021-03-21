Startseite der Community FreiFunk Kiel.
=======================================

Webseite: http://freifunk.in-kiel.de/blog

Um einen Blog Beitrag zu erstellen brauchst du keine weitere Software. Das Blog kannst du **direkt im Browser [hier auf Github](https://github.com/freifunk-kiel/ffki-blog/) bearbeiten**. 

Um die Hauptseiten zu bearbeiten, clone dises Repository und installiere ein paar Abhngigkeiten, dann kannst du auch bei dir lokal eine Kopie erstellen und testen:

Dependencies
------------

* ruby2.5
* ruby-nokogiri
* rubygems

### Gems

* jekyll
* json
* bundler

Install
-------

On Ubuntu/Debian:

    sudo apt-get install ruby2.5-dev ruby-nokogiri rubygems
    sudo apt purge ruby2.0* ruby2.1 ruby2.3 ruby2.4*
    sudo gem install json jekyll bundler
    #ggf.:
    #ln -s /usr/bin/gem$VERSION$ /usr/bin/gem
    #sudo chmod +x /usr/bin/gem
    git clone <repo-url> startseite
    cd startseite/
    git submodule update --init --recursive --remote
    bundle install

Customization
-------------
You should customize text in the following files:

 * treffen.html
 * mitmachen.html
 * distributor.html

Before you deploy the included `impressum.html` please contact
the "Förderverein Freie Netzwerke e. V." and ask for their
permission to do so. Thanks.

Build
-----

Choose an arbitrary location for the checkout of this repository. For editing above files, we suggest to create a new branch in your local git repository. Patches local to your installation then remain in that branch, others commit to your master branch and please push those back to the archive. 

The complete directory structure of what (under Debian/Ubuntu) should reside under `/path/to/www` will be built from the templates provided by

	jekyll build

On Ubuntu you might need to ensure the right environment with

        bundle exec jekyll build

The generated static pages will be stored in the subfolder `_site/`, that you should move somewhere outside of this repository. If something analogous to `rm -r /path/to/www; mv _site /path/to/www` is no possible, you may decided for something like

	(cd _site && tar cf - .)|(cd /path/to/www && sudo tar xf -)

to have the data transferred without deleting independent contributions.

Site
----

*The site doesn't run in a subdirectory*, it only works correctly if it is called via its own (sub)domain, so you have to configure your webserver to route a domain on the site-path, otherwise the links to stylesheets, images,.. are not implemented correctly, for example in apache add this to your sites-enabled:

	<VirtualHost *:80>
		ServerName freifunk.localhost
		DocumentRoot /path/to/www/
	</VirtualHost>


Aftermath
---------

There are several bits and pieces still missing after the installation of this startseite. 
 * map/graph/List from the ffnord/ffmap-d3 repository on github
 * integration of the www-providing machine with the batman-adv mesh
 * mailinglists and email setup in general
 * ...
