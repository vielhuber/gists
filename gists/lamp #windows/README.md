## features

- simple installation
- simple usage via command line
- full control over configuration
- default remote smtp relay for all mailings
- includes mysql with phpmyadmin and postgresql
- shared php.ini configuration for all versions
- switch php/cli version (globally and host based)
- access via all devices in your local network
- real ssl certificates for all hosts and all devices
- native linux performance (can handle node_modules and vendor)

## installation

#### hosts
- we abuse our own public domain as a dns that maps to a local ip in order to prevent setting local hosts AND having the ability to access via smartphones/tablets from the same network
- DomainFactory
- A-Records
- local.vielhuber.de => 192.168.178.21
- *.local.vielhuber.de => 192.168.178.21
- fritz.box > Heimnetz > Netzwerk > Netzwerkeinstellungen > DNS-Rebind-Schutz:
  - vielhuber.de
  - local.vielhuber.de
  - *.local.vielhuber.de
- restart FRITZ!Box

#### open firewall
- Windows Defender Firewall mit erweiterter Sicherheit
- Eingehende Regeln > Neue Regel > Port > TCP > 80, 443

#### wsl
- open PowerShell as admin
- ```Enable-WindowsOptionalFeature -Online -FeatureName Microsoft-Windows-Subsystem-Linux```
- reboot
- Windows Store > - "Ubuntu"
- Note: This is always the latest version, but needs manual upgrade; see https://blogs.msdn.microsoft.com/commandline/2018/07/09/upgrading-ubuntu/
- UNIX username: root (cancel when prompting for a new default username)
- Change password with ```passwd```: "root"
- ```sudo apt-get update && sudo apt-get upgrade```
- Netzlaufwerk "\wsl$\Ubuntu" auf W: mappen und umbenennen: "WSL"

#### colorize command line
- ```sudo nano ~/.bash_profile```
```
alias ls='ls --color'
LS_COLORS='di=1:fi=0:ln=31:pi=5:so=5:bd=5:cd=5:or=31:mi=0:ex=35:*.rpm=90'
export LS_COLORS
PS1="\n\[\e[1;30m\][$$:$PPID - \j:\!\[\e[1;30m\]]\[\e[0;36m\] \T \[\e[1;30m\][\[\e[1;34m\]\u@\H\[\e[1;30m\]:\[\e[0;37m\]${SSH_TTY:-o} \[\e[0;32m\]+${SHLVL}\[\e[1;30m\]] \[\e[1;37m\]\w\[\e[0;37m\] \n\$ "
```

#### install basic linux packages
- ```sudo apt-get install nano sshpass zip unzip htop ruby libnotify-bin```

#### apache/php/mysql
- ```sudo apt-get install apache2 mysql-server```
- ```sudo service apache2 start```
- ```sudo service mysql start```
- ```sudo mysql_secure_installation```
- Validate password plugin: n
- mysql-root-Passwort: root
- Remove anonymous users: y
- Disable root login remotely: n
- Remove test database: y
- Reload privilege tables: y

#### add ppa of officially maintained php versions
- ```sudo add-apt-repository ppa:ondrej/php```
- ```sudo apt-get update```

#### php extensions
- ```sudo apt-get install -y php5.6 php5.6-fpm libapache2-mod-php5.6 php5.6-mysql php5.6-cli php5.6-common php5.6-xdebug php5.6-mbstring php5.6-xmlrpc php5.6-gd php5.6-intl php5.6-xml php5.6-mysql php5.6-mcrypt php5.6-zip php5.6-soap php5.6-curl php5.6-bcmath php5.6-xml php5.6-sqlite php5.6-imap php5.6-opcache php5.6-pgsql php5.6-pdo php5.6-gd```
- ```sudo apt-get install -y php7.0 php7.0-fpm libapache2-mod-php7.0 php7.0-mysql php7.0-cli php7.0-common php7.0-xdebug php7.0-mbstring php7.0-xmlrpc php7.0-gd php7.0-intl php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-zip php7.0-soap php7.0-curl php7.0-bcmath php7.0-xml php7.0-sqlite php7.0-imap php7.0-opcache php7.0-pgsql php7.0-pdo php7.0-gd```
- ```sudo apt-get install -y php7.1 php7.1-fpm libapache2-mod-php7.1 php7.1-mysql php7.1-cli php7.1-common php7.1-xdebug php7.1-mbstring php7.1-xmlrpc php7.1-gd php7.1-intl php7.1-xml php7.1-mysql php7.1-mcrypt php7.1-zip php7.1-soap php7.1-curl php7.1-bcmath php7.1-xml php7.1-sqlite php7.1-imap php7.1-opcache php7.1-pgsql php7.1-pdo php7.1-gd```
- ```sudo apt-get install -y php7.2 php7.2-fpm libapache2-mod-php7.2 php7.2-mysql php7.2-cli php7.2-common php7.2-xdebug php7.2-mbstring php7.2-xmlrpc php7.2-gd php7.2-intl php7.2-xml php7.2-mysql php7.2-zip php7.2-soap php7.2-curl php7.2-bcmath php7.2-xml php7.2-sqlite php7.2-imap php7.2-opcache php7.2-pgsql php7.2-pdo php7.2-gd```
- ```sudo apt-get install -y php7.3 php7.3-fpm libapache2-mod-php7.3 php7.3-mysql php7.3-cli php7.3-common php7.3-xdebug php7.3-mbstring php7.3-xmlrpc php7.3-gd php7.3-intl php7.3-xml php7.3-mysql php7.3-zip php7.3-soap php7.3-curl php7.3-bcmath php7.3-xml php7.3-sqlite php7.3-imap php7.3-opcache php7.3-pgsql php7.3-pdo php7.3-gd```
- note: extensions must not be uncommented in php.ini but installed on the command line

#### apache extensions
- ```sudo a2enmod rewrite```
- ```sudo a2enmod ssl```
- ```sudo a2enmod vhost_alias```
- ```sudo a2enmod authz_groupfile```
- ```sudo a2enmod headers```
- ```sudo a2enmod cache```
- ```sudo a2enmod expires```
- ```sudo a2enmod actions```
- ```sudo a2enmod alias```
- ```sudo a2enmod proxy_fcgi```
- ```service apache2 restart```

#### configs
- setup with presets from gist.github.com
- ```sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf```
- ```sudo nano /etc/apache2/apache2.conf```
- ```sudo nano /etc/php/X.X/fpm/pool.d/www.conf```
- ```sudo nano /etc/php/X.X/apache2/php.ini``` (not needed, see below)
- ```sudo nano /etc/php/X.X/cli/php.ini``` (not needed, see below)

#### disable default host
- ```sudo a2dissite 000-default.conf```

#### ssl
- create a real let's encrypt certificate via https://zerossl.com/free-ssl/
- Domain: *.local.vielhuber.de
- DNS-verification via txt-record over DomainFactory
- key.txt => C:\htdocs\lamp\ssl.key
- crt.txt => C:\htdocs\lamp\ssl.cert

#### postfix
- ```sudo apt-get install postfix```
- ```sudo apt install mailutils```
- ```sudo dpkg-reconfigure postfix```
   - General type: "Internet Site"
   - System mail name: "vielhuber.de"
   - Root mail recipient: OK
   - Other destinations: OK
   - Force synchronous updates: NO
   - Local networks: OK
   - Mailbox size limit: OK
   - Local address extension: OK
   - Internet protocols: "ipv4"
- ```sudo nano /etc/postfix/main.cf```
```
    myhostname = vielhuber.de
    mydestination =
    relayhost = [sslout.df.eu]:587
    smtp_sasl_auth_enable = yes
    smtp_sasl_security_options = noanonymous
    smtp_sasl_password_maps = hash:/etc/postfix/sasl_passwd
    smtp_use_tls = yes
    smtp_tls_CAfile = /etc/ssl/certs/ca-certificates.crt
```
- ```sudo nano /etc/postfix/sasl_passwd```
  - ```[sslout.df.eu]:587 smtp@vielhuber.de:xxx```
- ```sudo postmap /etc/postfix/sasl_passwd```
- ```sudo service postfix restart```
- ```sudo service rsyslog restart```
- ```echo "Das ist ein Test" | mail -s "Test bestanden" -a "From: smtp@vielhuber.de" david@vielhuber.de```
- ```sudo nano /etc/php/custom.ini```
  - ```sendmail_path = "/usr/sbin/sendmail -t -i"```

#### shared php.ini configuration
- ```sudo nano /etc/php/custom.ini```
```
max_execution_time = 2400
max_input_time = 900
post_max_size = 800M
memory_limit = 2048M
upload_max_filesize = 800M
max_input_vars = 100000
max_file_uploads = 5000
realpath_cache_size = 4M
allow_url_include = On
date.timezone = 'Europe/Berlin'
display_errors = On
#error_reporting = E_ALL & ~E_NOTICE
error_reporting = E_ALL
phar.readonly = 0

opcache.enable=1
opcache.enable_cli=0
opcache.memory_consumption=512
opcache.interned_strings_buffer=64
opcache.max_accelerated_files=32531
opcache.save_comments=1
opcache.fast_shutdown=0
opcache.max_file_size=0
opcache.validate_timestamps=1 # we set this to 1 (so that we can set revalidate_freq on a project basis to a higher value)
opcache.revalidate_freq=2

[XDebug]
xdebug.remote_enable = 1
xdebug.remote_autostart = 1
xdebug.max_nesting_level = 10000
```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/cli/conf.d/custom.ini```

#### fix small wsl warnings
- ```sudo nano /etc/apache2/apache2.conf```
- AcceptFilter https none
- AcceptFilter http none
- ```sudo service mysql stop```
- ```sudo usermod -d /var/lib/mysql/ mysql```

#### composer
- ```php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"```
- ```php composer-setup.php```
- ```php -r "unlink('composer-setup.php');"```
- ```sudo mv composer.phar /usr/local/bin/composer```
- hide sudo message:
  - ```sudo nano ~/.bash_profile```
  - ```export COMPOSER_ALLOW_SUPERUSER=1```

#### node / npm
- nvm
  - ```curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash```
  - copy 3 new lines of ```~/.bashrc``` to ```~/.bash_profile``` (because .bashrc is not loaded on wsl)
  - ```nvm --version```
  - ```nvm install node```
  - ```nvm install --lts```
  - ```nvm use node```
  - Bei manchen Kundenprojekten: ```nvm use --lts```
- nativ (obsolet)
  - https://nodejs.org/en/download/package-manager/#debian-and-ubuntu-based-linux-distributions
  - ```curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -```
  - ```sudo apt-get install -y nodejs```
  - ```sudo apt-get install -y build-essential```

#### yarn
- ```curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -```
- ```echo "deb https://nightly.yarnpkg.com/debian/ nightly main" | sudo tee /etc/apt/sources.list.d/yarn.list```
- ```sudo apt-get update && sudo apt-get install yarn```

#### python
- ```sudo apt-get update```
- ```sudo apt-get install python python-pip python3 python3-pip```
- ```sudo python --version```
- ```sudo pip --version```
- ```sudo python3 --version```
- ```sudo pip3 --version```
- ```cd /usr/bin && sudo rm python && ln -s ./python3 ./python``` (currently not active)

#### git
- ```sudo apt-get install git```
- ```git config --global core.filemode false```
- ```git config --global core.autocrlf true``` # this converts everything to crlf, which is needed for editors in windows
- ```git config --global core.safecrlf false```
- ```git config --global push.default simple```
- ```git config --global user.name "David Vielhuber"```
- ```git config --global user.email "david@vielhuber.de"```
- ```git config --global core.mergeoptions --no-edit```

#### lamp repo
- in this repo we store our ssl certificate, our ssh keys and all current active symlinks
- ```mkdir /mnt/c/htdocs```
- ```mkdir /mnt/c/htdocs/lamp```
- ```cd /mnt/c/htdocs/lamp```
- ```git clone git@bitbucket.org:vielhuber/lamp.git . --config core.autocrlf=false```
- ```sudo nano ~/.bash_profile```
- export PATH="$PATH:/mnt/c/htdocs/lamp"

#### ssh
- ```mkdir ~/.ssh```
- ```cp /mnt/c/htdocs/lamp/id_rsa ~/.ssh/id_rsa```
- ```cp /mnt/c/htdocs/lamp/id_rsa.pub ~/.ssh/id_rsa.pub```
- ```chmod 600 ~/.ssh/id_rsa```
- ```chmod 600 ~/.ssh/id_rsa.pub```

#### syncdb
- ```mkdir ~/.syncdb```
- ```cd ~/.syncdb```
- ```composer require vielhuber/syncdb```
- ```chmod +x vendor/vielhuber/syncdb/src/syncdb```
- ```ln -s /mnt/c/htdocs/lamp/syncdb ~/.syncdb/profiles```
- ```sudo nano ~/.bash_profile```
- export PATH="$PATH:/root/.syncdb/vendor/vielhuber/syncdb/src"

#### postgres
- ```nano /etc/apt/sources.list.d/pgdg.list```
- ```deb http://apt.postgresql.org/pub/repos/apt/ bionic-pgdg main```
- ```wget --quiet -O - https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo apt-key add -```
- ```sudo apt-get update```
- ```sudo apt-get install postgresql postgresql-contrib```
- sudo nano /etc/postgresql/11/main/postgresql.conf
  - listen_addresses = '*'
  - port = 5432
- PANIC: could not flush dirty data
  - sudo nano /etc/postgresql/11/main/postgresql.conf
  - data_sync_retry = on
- ```sudo service postgresql start```
- ```sudo -u postgres psql```
- ```\password postgres```
- root
- ```\q```
- ```nano ~/.pgpass```
- ```*:5432:*:postgres:root```
- ```chmod 0600 ~/.pgpass```
- sudo nano /etc/postgresql/11/main/pg_hba.conf
```
# comment out all other lines and append this
local   all   postgres                  md5
local   all   all                       md5
host    all   all        127.0.0.1/32   md5
host    all   all        ::1/128        md5
```

#### ghostscript
- ```sudo apt-get install ghostscript```
- ```ghostscript -v```

#### imagemagick
- ```sudo apt-get install imagemagick imagemagick-doc```
- ```convert --version```
- ```sudo nano /etc/ImageMagick-6/policy.xml```
- comment line <!-- <policy domain="coder" rights="none" pattern="MVG" /> -->
- change ```<policy domain="coder" rights="none" pattern="PDF" />``` to ```<policy domain="coder" rights="read|write" pattern="PDF" />```
- add ```<policy domain="coder" rights="read|write" pattern="LABEL" />```

#### pdftk
- ```sudo add-apt-repository ppa:malteworld/ppa```
- ```sudo apt update```
- ```sudo apt install pdftk```
- ```pdftk --version```

#### wkhtmltopdf
- ```sudo apt-get install libfontconfig1 libxrender1 xfonts-75dpi xfonts-base```
- ```cd /tmp/```
- ```mkdir dl```
- ```cd dl```
- ```wget https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.bionic_amd64.deb```
- ```sudo dpkg -i wkhtmltox_0.12.5-1.bionic_amd64.deb```
- ```cd /tmp/```
- ```rm -rf dl```
- ```wkhtmltopdf --version```

#### cpdf
- ```cd /opt/```
- ```wget https://github.com/coherentgraphics/cpdf-binaries/archive/master.zip```
- ```unzip master.zip```
- ```mv cpdf-binaries-master/Linux-Intel-64bit/cpdf /usr/local/bin/cpdf```
- ```rm -rf cpdf-binaries-master```
- ```rm master.zip```
- ```cpdf --help```

#### jpegoptim
- ```sudo apt-get install jpegoptim```

#### mozjpeg
- ```sudo apt-get update```
- ```sudo apt-get install -y autoconf automake libtool nasm make pkg-config```
- ```cd /tmp/```
- ```mkdir mozjpeg```
- ```cd mozjpeg```
- ```wget https://github.com/mozilla/mozjpeg/archive/v3.3.1.tar.gz```
- ```tar -xzvf v3.3.1.tar.gz```
- ```cd mozjpeg-3.3.1/```
- ```autoreconf -fiv```
- ```mkdir build && cd build```
- ```sh ../configure```
- ```make install```
- ```ln -s /opt/mozjpeg/bin/jpegtran /usr/bin/mozjpeg```
- ```cd ..```
- ```cd ..```
- ```cd ..```
- ```rm -rf mozjpeg```
- ```mozjpeg --version```

#### pngquant
- ```sudo apt-get update```
- ```sudo apt-get install -y git gcc cmake libpng-dev pkg-config```
- ```cd /tmp/```
- ```mkdir pngquant```
- ```cd pngquant```
- ```wget http://pngquant.org/pngquant-2.12.5-src.tar.gz```
- ```tar -xzvf pngquant-2.12.5-src.tar.gz```
- ```cd pngquant-2.12.5/```
- ```./configure```
- ```make```
- ```sudo make install```
- ```cd ..```
- ```cd ..```
- ```rm -rf pngquant```
- ```pngquant --version```

#### svgo
- ```npm install -g svgo```
- ```svgo --version```

#### gifsicle
- ```sudo apt-get update```
- ```sudo apt-get install -y git gcc cmake libpng-dev pkg-config```
- ```cd /tmp/```
- ```mkdir gifsicle```
- ```cd gifsicle```
- ```wget https://github.com/kohler/gifsicle/archive/v1.92.tar.gz```
- ```tar -xzvf v1.92.tar.gz```
- ```cd gifsicle-1.92/```
- ```autoreconf -i```
- ```./configure```
- ```make```
- ```sudo make install```
- ```cd ..```
- ```cd ..```
- ```rm -rf gifsicle/```
- ```gifsicle --version```

#### phpmyadmin
- ```sudo apt-get install phpmyadmin```
  - Web server to reconfigure automatically: apache2
  - Configure database for phpmyadmin with dbconfig-common: Yes
  - MySQL application password for phpmyadmin: root
- ln -s /usr/share/phpmyadmin /mnt/c/htdocs/phpmyadmin
- lamp add phpmyadmin
- https://phpmyadmin.local.vielhuber.de

#### include windows fonts in linux
- ```ln -s /mnt/c/Windows/Fonts /usr/share/fonts/WindowsFonts```
- ```fc-cache```

#### clasp
- ```npm i @google/clasp -g```
- https://script.google.com/home/usersettings => enable
- ```npm i -S @types/google-apps-script```
- ```clasp login```

#### ruby (via rvm)
- ```gpg --keyserver hkp://pool.sks-keyservers.net --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3 7D2BAF1CF37B13E2069D6956105BD0E739499BDB```
- ```curl -sSL https://get.rvm.io | bash -s stable --ruby```
- ```ruby --version```

#### wpscan
- ```sudo apt-get install zlib1g-dev```
- ```gem install wpscan```
- ```wpscan --update```
- ```gem update wpscan```
- ```wpscan --url https://www.domain.tld```

#### wp-cli
- ```curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar```
- ```chmod +x wp-cli.phar```
- ```sudo mv wp-cli.phar /usr/local/bin/wp```
- ```sudo nano ~/.bash_profile```
- ```alias wp='wp --allow-root'```
- ```wp --info```

#### ffmpeg
- ```sudo add-apt-repository ppa:jonathonf/ffmpeg-4```
- ```sudo apt-get update```
- ```sudo apt install ffmpeg```
- ```ffmpeg -version```

#### inkscape
- ```sudo apt-get install inkscape```

#### rsvg
- ```sudo apt-get install librsvg2-bin```

#### autostart services
- Aufgabenplanung
- "lamp"
- Nur ausführen, wenn der Benutzer angemeldet ist
- Trigger: Bei Anmeldung, verzögern für: 90 Sekunden
- Aktion: Programm starten (C:\htdocs\lamp\start.bat)

#### wsl improve i/o performance
- https://medium.com/@leandrw/speeding-up-wsl-i-o-up-than-5x-fast-saving-a-lot-of-battery-life-cpu-usage-c3537dd03c74
- Windows Defender Security Center > Viren- & Bedrohungsschutz > Einstellungen für Viren- & Bedrohungsschutz > Ausschlüsse hinzufügen oder entfernen
  - Ordner: C:\Users\David\AppData\Local\Packages\CanonicalGroupLimited.UbuntuonWindows_79rhkp1fndgsc
  - Prozesse: git, node, dpkg, php5.6, php7.0, php7.1, php7.2, php7.3, php-fpm5.6, php-fpm7.0, php-fpm7.1, php-fpm7.2, php-fpm7.3, mysql, mysqld, apache2, bash, postgres, wkhtmltopdf

#### switch cli php version
- ```sudo update-alternatives --config php```
- always choose manual mode (so newer installed versions do not get taken automatically)
- ```php -v```

#### switch global php version
- ```sudo a2dismod phpY.Y```
- ```sudo a2enmod phpX.X```

#### switch clients
- you can setup lamp on multiple clients
- option 1: point the dns record to the current active client (currently used)
- option 2: setup a more dynamic approach like 01.project-name.local.vielhuber.de, 02.project-name.local.vielhuber.de, ...

## usage

#### start
- ```lamp start```

#### restart
- ```lamp restart```

#### stop
- ```lamp stop```

#### create project
- ```lamp add project```
- ```lamp add project php7.3```
- ```lamp add project php7.3 custom/subfolder/public```

#### remove project
- ```lamp remove project```

