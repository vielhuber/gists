## features

- simple installation
- simple usage via command line
- full control over configuration
- default remote smtp relay for all mailings
- databases included: mysql (+phpmyadmin), postgresql, oraclesql
- shared php.ini configuration for all versions
- switch php/cli version (globally and host based)
- access via all devices in your local network
- support for different networks
- real ssl certificates for all hosts and all devices
- supports reverse proxy configuration
- native linux performance (can handle node_modules and vendor) with wsl2

## installation

#### hosts

##### dns based

- we abuse our own public domain as a dns that maps to a local ip in order to prevent setting local hosts AND having the ability to access via smartphones/tablets from the same network
- DomainFactory
- A-Records
- local.vielhuber.de => 192.168.188.22
- *.local.vielhuber.de => 192.168.188.22
- fritz.box > Heimnetz > Netzwerk > Netzwerkeinstellungen > DNS-Rebind-Schutz:
  - vielhuber.de
  - local.vielhuber.de
  - *.local.vielhuber.de
- restart FRITZ!Box

##### local based

- run powershell as adminstrator
- `PowerShell -Command "Set-ExecutionPolicy RemoteSigned -scope Process; iwr -useb https://raw.githubusercontent.com/gerardog/gsudo/master/installgsudo.ps1 | iex"`
- uncomment `"/mnt/c/Users/David/apps/gsudo/gsudo.exe" -d "echo 127.0.0.1 $PROJECT.local.vielhuber.de >> %windir%\System32\drivers\etc\hosts"` from `lamp`

#### open firewall
- not used, because we use firewall.ps1 (see below)
- ~~Windows Defender Firewall mit erweiterter Sicherheit~~
- ~~Eingehende Regeln > Neue Regel > Port > TCP > 80, 443~~

#### wsl
- open PowerShell as admin
- ```Enable-WindowsOptionalFeature -Online -FeatureName Microsoft-Windows-Subsystem-Linux```
- reboot
- Windows Store > "Ubuntu 18.04 LTS"
  - available versions: https://blogs.msdn.microsoft.com/commandline/2018/07/09/upgrading-ubuntu/
  - i had problems in using the version "Ubuntu" (it was not 18, but 16), so just always use the last direct version
- UNIX username: root (cancel when prompting for a new default username)
- Change password with ```passwd```: "root"
- ```sudo apt-get update && sudo apt-get upgrade```
- Netzlaufwerk "\\wsl$\Ubuntu" auf W: mappen und umbenennen: "WSL"

#### prevent password prompt for sudo commands
- ```sudo visudo```
- comment out ```%sudo ALL=(ALL:ALL) ALL```
- ```%sudo ALL=(ALL:ALL) NOPASSWD:ALL```

#### wsl2
- open PowerShell as admin
- `dism.exe /online /enable-feature /featurename:Microsoft-Windows-Subsystem-Linux /all /norestart`
- `dism.exe /online /enable-feature /featurename:VirtualMachinePlatform /all /norestart`
- reboot
- `wsl --list --verbose`
- `wsl --set-default-version 2`
- `wsl --set-version Ubuntu 2`
- `wsl --list --verbose`

#### backup/restore wsl2
- Run PowerShell as admin
- `wsl --shutdown`
- `wsl --list`
- `wsl --export "Ubuntu" D:\Ubuntu.tar`
- `wsl --import "Ubuntu" D:\ D:\Ubuntu.tar`

#### increase disk size
- https://docs.microsoft.com/en-us/windows/wsl/vhd-size
- Powershell (Admin)
  - `wsl --shutdown`
  - `Get-AppxPackage -Name "*Ubuntu*" | Select PackageFamilyName`
  - `C:\Users\David\AppData\Local\Packages\CanonicalGroupLimited.UbuntuonWindows_79rhkp1fndgsc\LocalState\ext4.vhdx`
- CMD (Admin)
  - `diskpart`
  - `Select vdisk file="C:\Users\David\AppData\Local\Packages\CanonicalGroupLimited.UbuntuonWindows_79rhkp1fndgsc\LocalState\ext4.vhdx"`
  - `detail vdisk`
  - `expand vdisk maximum=316000`
  - `exit`
- WSL
  - `sudo mount -t devtmpfs none /dev`
  - `mount | grep ext4`
  - `sudo resize2fs /dev/sdb 316000M`
  - `df -h`

#### docker
-	Download Docker desktop: https://hub.docker.com/editions/community/docker-ce-desktop-windows/
-	Installation: "Install required Windows components for WSL 2"
-	Settings > General > "Use the WSL 2 based engine"
- Login with account
- ```docker version```
- ```docker-compose version```

#### xserver

- download vcxsrv (https://sourceforge.net/projects/vcxsrv/files/latest/download)
- Installation: Full
- `nano ~/.bash_profile`
- `export DISPLAY=$(awk '/nameserver / {print $2; exit}' /etc/resolv.conf 2>/dev/null):0`
- `export LIBGL_ALWAYS_INDIRECT=1`
- `source ~/.bash_profile`
- XLaunch
- Multiple Windows
- Display number -1
- Start no client
- Disable access control: an
- Zugriff zulassen
- Windows Defender Firwall mit erweiterter Sicherheit > Eingehende Regeln > "VcXsrv windows xserver" 2x rot Doppelklick > Verbindung zulassen
- Autostart
  - Aufgabenplanung
  - "vcxsrv"
  - Nur ausführen, wenn der Benutzer angemeldet ist
  - Trigger: Bei Anmeldung
  - Aktion: Programm starten
  - "C:\Program Files\VcXsrv\vcxsrv.exe" :0 -multiwindow -ac -clipboard -wgl
- install desktop
  - apt-get update
  - apt-get install gedit
  - gedit
  - apt-get install xfce4
  - startxfce4
    - Applications > Settings > Screensaver > Mode: Disable Screensaver

#### vscode

- install Remote - WSL Installieren
- Erweiterungen > Wolke: Lokale Erweiterungen in WSL - Ubuntu installieren > Alle markieren
- Innerhalb von WSL ausführen: `code .`

#### smartgit

- `cd /usr/local`
- `wget https://www.syntevo.com/downloads/smartgit/smartgit-linux-20_1_4.tar.gz`
- `tar xzf smartgit-linux-20_1_4.tar.gz`
- `rm smartgit-linux-20_1_4.tar.gz`
- `nano usr/local/bin/sgit`
- `( /usr/local/smartgit/bin/smartgit.sh & ) > /dev/null 2>&1`
- `chmod +x usr/local/bin/sgit`
- `sgit`
- Non-commercial use only
- User Name: David Vielhuber
- Email: david@vielhuber.de
- Use SmartGit as SSH client
- Style: Working Tree
- Edit > Preferences > User Interface > Dark (independent of system)
- Edit > Preferences > User Interface > On start-up: Open the last used repositories AUS
- Edit > Preferences > User Interface > Built-in Text Editors > Font Size: 9
- Repository > Search for Repositories > /var/www
- Optional: Alle Repositories: Rechte Maustaste: Mark as favorite (dies erhöht Performance durch Background Refresh)
- Wenn non-commercial Lizenz abläuft: rm -rf ~/.config/smartgit/
- Wenn es Probleme mit GTK gibt: ```nano ~/.config/smartgit/smartgit.vmoptions```, ```swtver=4932``` hinzufügen
- Falls Updateprozess innerhalb des Programms scheitert: Einfach neue tar.gz downloaden, entzippen (und bestehende Dateien überschreiben)

#### pimp command line
- ```sudo nano ~/.bash_profile```
```
# colorize and show git branch name
alias ls='ls --color'
LS_COLORS='di=1:fi=0:ln=31:pi=5:so=5:bd=5:cd=5:or=31:mi=0:ex=35:*.rpm=90'
export LS_COLORS
parse_git_branch() { git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'; }
PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u@\h\[\033[00m\]~\[\e[0;36m\]\T\[\033[00m\]~\[\033[01;34m\]\w\[\033[01;31m\]$(parse_git_branch)\[\033[00m\]\$ '
```
- ```source ~/.bash_profile```

#### install basic linux packages
- ```sudo apt-get install nano sshpass zip unzip htop ruby libnotify-bin net-tools pv csh```

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
- allow login to root user without sudo
  - ```sudo mysql -u root```
  - ```DROP USER 'root'@'localhost';```
  - ```CREATE USER 'root'@'%' IDENTIFIED BY '';```
  - ```GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' WITH GRANT OPTION;```
  - ```FLUSH PRIVILEGES;```
  - ```EXIT```
  - ```mysql -u root```
  - ```SET PASSWORD FOR root = 'root';```
  - ```EXIT```

#### add ppa of officially maintained php versions
- ```sudo add-apt-repository ppa:ondrej/php```
- ```sudo apt-get update```

#### php extensions
- ```sudo apt-get install -y php5.6 php5.6-fpm libapache2-mod-php5.6 php5.6-mysql php5.6-cli php5.6-common php5.6-xdebug php5.6-mbstring php5.6-xmlrpc php5.6-gd php5.6-intl php5.6-xml php5.6-mysql php5.6-mcrypt php5.6-zip php5.6-soap php5.6-curl php5.6-bcmath php5.6-xml php5.6-sqlite php5.6-imap php5.6-opcache php5.6-pgsql php5.6-pdo php5.6-gd php5.6-imagick```
- ```sudo apt-get install -y php7.0 php7.0-fpm libapache2-mod-php7.0 php7.0-mysql php7.0-cli php7.0-common php7.0-xdebug php7.0-mbstring php7.0-xmlrpc php7.0-gd php7.0-intl php7.0-xml php7.0-mysql php7.0-mcrypt php7.0-zip php7.0-soap php7.0-curl php7.0-bcmath php7.0-xml php7.0-sqlite php7.0-imap php7.0-opcache php7.0-pgsql php7.0-pdo php7.0-gd php7.0-imagick```
- ```sudo apt-get install -y php7.1 php7.1-fpm libapache2-mod-php7.1 php7.1-mysql php7.1-cli php7.1-common php7.1-xdebug php7.1-mbstring php7.1-xmlrpc php7.1-gd php7.1-intl php7.1-xml php7.1-mysql php7.1-mcrypt php7.1-zip php7.1-soap php7.1-curl php7.1-bcmath php7.1-xml php7.1-sqlite php7.1-imap php7.1-opcache php7.1-pgsql php7.1-pdo php7.1-gd php7.1-imagick```
- ```sudo apt-get install -y php7.2 php7.2-fpm libapache2-mod-php7.2 php7.2-mysql php7.2-cli php7.2-common php7.2-xdebug php7.2-mbstring php7.2-xmlrpc php7.2-gd php7.2-intl php7.2-xml php7.2-mysql php7.2-zip php7.2-soap php7.2-curl php7.2-bcmath php7.2-xml php7.2-sqlite php7.2-imap php7.2-opcache php7.2-pgsql php7.2-pdo php7.2-gd php7.2-imagick```
- ```sudo apt-get install -y php7.3 php7.3-fpm libapache2-mod-php7.3 php7.3-mysql php7.3-cli php7.3-common php7.3-xdebug php7.3-mbstring php7.3-xmlrpc php7.3-gd php7.3-intl php7.3-xml php7.3-mysql php7.3-zip php7.3-soap php7.3-curl php7.3-bcmath php7.3-xml php7.3-sqlite php7.3-imap php7.3-opcache php7.3-pgsql php7.3-pdo php7.3-gd php7.3-imagick```
- ```sudo apt-get install -y php7.4 php7.4-fpm libapache2-mod-php7.4 php7.4-mysql php7.4-cli php7.4-common php7.4-xdebug php7.4-mbstring php7.4-xmlrpc php7.4-gd php7.4-intl php7.4-xml php7.4-mysql php7.4-zip php7.4-soap php7.4-curl php7.4-bcmath php7.4-xml php7.4-sqlite php7.4-imap php7.4-opcache php7.4-pgsql php7.4-pdo php7.4-gd php7.4-imagick```
- ```sudo apt-get install -y php8.0 php8.0-fpm libapache2-mod-php8.0 php8.0-mysql php8.0-cli php8.0-common php8.0-xdebug php8.0-mbstring php8.0-xmlrpc php8.0-gd php8.0-intl php8.0-xml php8.0-mysql php8.0-zip php8.0-soap php8.0-curl php8.0-bcmath php8.0-xml php8.0-sqlite php8.0-imap php8.0-opcache php8.0-pgsql php8.0-pdo php8.0-gd php8.0-imagick```
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
- ```sudo a2enmod proxy```
- ```sudo a2enmod proxy_html```
- ```sudo a2enmod proxy_http```
- ```sudo a2enmod xml2enc```
- ```sudo service apache2 restart```

#### configs
- setup with presets from gist.github.com
- ```sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf```
- ```sudo nano /etc/apache2/apache2.conf```
- ```sudo nano /etc/php/X.X/fpm/pool.d/www.conf``` (important!)
- ```sudo nano /etc/php/X.X/apache2/php.ini``` (not needed, see below)
- ```sudo nano /etc/php/X.X/cli/php.ini``` (not needed, see below)

#### disable default host
- ```sudo a2dissite 000-default.conf```

#### ssl
- create a real let's encrypt certificate via https://punchsalad.com/ssl-certificate-generator/
- Domain: *.local.vielhuber.de
- DNS-verification via txt-record over DomainFactory
- private-key.txt => \\wsl$\Ubuntu\var\www\lamp\ssl.key
- ca-bundle.txt => \\wsl$\Ubuntu\var\www\lamp\ssl.cert

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

#### php error logging
- ```touch /var/log/php-error.log```
- ```chmod +x /var/log/php-error.log```
- in combination with ```error_log``` in php.ini logging now works for both php fpm (this is always the case for specific versions) and php as an apache module (this is always the case for general version)

#### shared php.ini configuration
- ```sudo nano /etc/php/custom.ini```
```
max_execution_time = 2400
max_input_time = 900
post_max_size = 800M
memory_limit = 4048M
upload_max_filesize = 800M
max_input_vars = 100000
max_file_uploads = 5000
realpath_cache_size = 4M
#allow_url_include = On
#allow_url_fopen = On
date.timezone = 'Europe/Berlin'
display_errors = On
error_log = /var/log/php-error.log
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
#we set this to 1 (so that we can set revalidate_freq on a project basis to a higher value)
opcache.validate_timestamps=1
opcache.revalidate_freq=2

[XDebug]
xdebug.profiler_enable = off
xdebug.max_nesting_level = 10000
xdebug.var_display_max_children= -1
xdebug.var_display_max_data = -1
xdebug.var_display_max_depth = -1
```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/cli/conf.d/custom.ini```

#### local environment permissions
- reset
  - `chown -R root:root /var/www`
  - `chmod 00755 /var`
  - `chmod 00755 /var/www`
  - `find /var/www -type d -exec chmod 00755 {} \;`
  - `find /var/www -type f -exec chmod 00644 {} \;`
- run php as root
  - `nano /etc/php/X.X/fpm/pool.d/www.conf`
  - **be aware: comment out with ";" instead of "#" :)**
    - `user = root`
    - `group = root`
  - `nano /etc/init.d/phpX.X-fpm`
    - `DAEMON_ARGS="-R --daemonize --fpm-config $CONFFILE"`
  - `service phpX.X-fpm restart`

#### fix small wsl warnings
- ```sudo nano /etc/apache2/apache2.conf```
- AcceptFilter https none
- AcceptFilter http none
- ```sudo service mysql stop```
- ```sudo usermod -d /var/lib/mysql/ mysql```

#### fix font errors
- if fonts are garbled: ```sudo fc-cache -f -v```

#### fix wsl2 errors
- apache not reachable
  - \\wsl$\Ubuntu\var\www\lamp\firewall.ps1 anlegen mit Inhalt von https://github.com/microsoft/WSL/issues/4150#issuecomment-504209723
  - Ports in Datei erweitern: ```$ports=@(80,443,10000,3000,3009,5000,8080,9090,3306);```
  - Aufgabenplanung
  - wsl2 Firewall
  - Bei Anmeldung
  - Verzögern für 30 Sekunden
  - Programm starten
  - PowerShell.exe -File \\wsl$\Ubuntu\var\www\lamp\firewall.ps1
  - Mit höchsten Privilegien ausführen
  - OBSOLET: etc/hosts: 172.31.142.215 ***.vielhuber.de
  - OBSOLET: Oder alternativ bei DF von 192.168.188.22 auf 172.31.142.215 setzen (muss ich später wieder rückgängig machen!)
  - OBSOLET: etc/hosts: #127.0.0.1      localhost und #::1             localhost einkommentieren
- php error
  - `mkdir -p /run/php/`
- /tmp clean
  - `find /tmp -ctime +2 -exec rm -rf {} +`
- remove zone identifier files
  - `find . -name "*:Zone.Identifier" -type f -delete`
- ram overload
  - create `%UserProfile%\.wslconfig`
  ```
  [wsl2]
  memory=8GB
  swap=16GB
  localhostForwarding=true
  ```
- wsl hangs after a while / vscode hangs
  - Docker > Settings > Start Docker Desktop when you log in: aus
  - NOT USED: WIN+R > SystemPropertiesAdvanced > Erweitert > Leistung > Einstellungen... > Erweitert > Virtueller Arbeitsspeicher > Ändern... > Dateigröße für alle Laufwerke automatisch verwalten: aus & C: > Benutzerdefinierte Größe: 800 MB - 1024 MB; CMD als Admin: wmic computersystem where name="%computername%" set AutomaticManagedPagefile=false

#### composer
- ```sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"```
- ```sudo php composer-setup.php```
- ```sudo php -r "unlink('composer-setup.php');"```
- ```sudo mv composer.phar /usr/local/bin/composer```
- hide sudo message:
  - ```sudo nano ~/.bash_profile```
  - ```export COMPOSER_ALLOW_SUPERUSER=1```
- ```composer self-update```
- ```composer --version``` # 2

#### node / npm
- nvm
  - ```sudo curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.34.0/install.sh | bash```
  - copy 3 new lines of ```~/.bashrc``` to ```~/.bash_profile``` (because .bashrc is not loaded on wsl)
  - restart terminal
  - ```nvm --version```
  - ```nvm ls```
  - install/upgrade new/specific node versions
  - ```nvm install node```
  - ```nvm install --lts```
  - ```nvm install 16.5.0```
  - ```nvm install 14.18.0```
  - ```nvm install 12.10.0```
  - ```nvm install 10.16.3```
  - ```nvm alias default 14.18.0```
  - Version wechseln: ```nvm use 10.16.3```
  - Cache leeren (falls sich package-lock.json ändert: `npm cache verify` bzw `npm cache clean -f`)
- nativ (obsolet)
  - https://nodejs.org/en/download/package-manager/#debian-and-ubuntu-based-linux-distributions
  - ```curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -```
  - ```sudo apt-get install -y nodejs```
  - ```sudo apt-get install -y build-essential```
- prevent permission errors
  - ```npm set unsafe-perm true```
- auto version switching on cd
  - ```nano ~/.bash_profile```
  - ```nvm_auto_switch() { if [[ $PWD == $PREV_PWD ]]; then return; fi; PREV_PWD=$PWD; [[ -f ".nvmrc" ]] && nvm use; }; export PROMPT_COMMAND=nvm_auto_switch;```
  - now place `.nvmrc` with the version (e.g. `12.10.0`) in the folder, where your `package.json` lays

#### yarn
- ```curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add -```
- ```echo "deb https://nightly.yarnpkg.com/debian/ nightly main" | sudo tee /etc/apt/sources.list.d/yarn.list```
- ```sudo apt-get update && sudo apt-get install yarn```

#### python
- install python 2
  - ```sudo apt-get update```
  - ```sudo apt-get install python python-pip```
  - ```python --version```
  - ```pip --version```
- install python 3.5
  - ```sudo apt-get update```
  - ```sudo apt-get install python3 python3-pip```
  - ```python3 --version```
  - ```pip3 --version```
- install python 3.6
  - ```sudo add-apt-repository ppa:deadsnakes/ppa```
  - ```sudo apt-get update```
  - ```sudo apt-get install python3.6```
  - ```python3.6 --version```
  - ```python3.6 -m pip --version```
- change default version (currently not done)
  - ```cd /usr/bin && sudo rm python && ln -s ./python3 ./python```

#### blackfire.io php debugger

- ```wget -q -O - https://packages.blackfire.io/gpg.key | sudo apt-key add -```
- ```echo "deb http://packages.blackfire.io/debian any main" | sudo tee /etc/apt/sources.list.d/blackfire.list```
- ```sudo apt update```
- ```sudo apt install blackfire-agent```
- ```sudo blackfire-agent --register --server-id=xxx --server-token=xxx``` (see blackfire.io)
- ```sudo /etc/init.d/blackfire-agent restart```
- ```sudo apt install blackfire-php```
- ```blackfire config --client-id=xxx --client-token=xxx``` (see blackfire.io)
- ```blackfire run ./vendor/bin/phpunit```

#### git
- ```sudo add-apt-repository ppa:git-core/ppa -y```
- ```sudo apt-get update```
- ```sudo apt-get install git -y```
- ```git --version```
- ```git config --global core.ignorecase false```
- ```git config --global pull.rebase false```
- ```git config --global core.filemode false```
- ```git config --global core.autocrlf input``` # this converts everything to lf on commit, which is ok when using wsl2 (however, there are projects where you want it to be the default value of `false`, set that with `git config core.autocrlf false`)
- ```git config --global core.safecrlf false```
- ```git config --global push.default simple```
- ```git config --global user.name "David Vielhuber"```
- ```git config --global user.email "david@vielhuber.de"```
- ```git config --global pull.ff only```
- ```git config --global merge.ff false```
- ```git config --global core.mergeoptions --no-edit```
- further do this (--no-edit does sometimes not work):
  - ```sudo nano ~/.bash_profile```
  - ```export GIT_MERGE_AUTOEDIT=no```
- node 10 hangs (https://stackoverflow.com/questions/45433130/npm-install-gets-stuck-at-fetchmetadata/72391698#72391698)
  - ```sudo nano ~/.gitconfig```
  - ```[url "https://"]```
  - ```   insteadOf = git://```

#### gh (github command line)
- ```curl -fsSL https://cli.github.com/packages/githubcli-archive-keyring.gpg | sudo dd of=/usr/share/keyrings/githubcli-archive-keyring.gpg```
- ```echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/githubcli-archive-keyring.gpg] https://cli.github.com/packages stable main" | sudo tee /etc/apt/sources.list.d/github-cli.list > /dev/null```
- ```sudo apt update```
- ```sudo apt install gh```

#### git-filter-repo
- `sudo nano ~/.bash_profile`
- `export PATH="$PATH:${HOME}/.git-filter-repo"`
- `source ~/.bash_profile`
- `mkdir -p ~/.git-filter-repo`
- `wget -O ~/.git-filter-repo/git-filter-repo https://raw.githubusercontent.com/newren/git-filter-repo/main/git-filter-repo`
- `chmod +x ~/.git-filter-repo/git-filter-repo`

#### subversion (svn)
- ```sudo apt-get install subversion```
- ```svn --version```

#### lamp repo
- in this repo we store our ssl certificate, our ssh keys and all current active symlinks
- ```mkdir /var/www/lamp```
- ```cd /var/www/lamp```
- ```git clone git@bitbucket.org:vielhuber/lamp.git . --config core.autocrlf=false```
- ```chmod +x /var/www/lamp/lamp```
- ```sudo visudo```
  - add ```/var/www/lamp``` to ```Defaults  secure_path```
- ```sudo nano ~/.bash_profile```
- ```export PATH="$PATH:/var/www/lamp"```
- ```source ~/.bash_profile```

#### ssh
- ```mkdir ~/.ssh```
- ```cp /var/www/lamp/id_rsa ~/.ssh/id_rsa```
- ```cp /var/www/lamp/id_rsa.pub ~/.ssh/id_rsa.pub```
- ```cp /var/www/lamp/id_rsa_4096 ~/.ssh/id_rsa_4096```
- ```cp /var/www/lamp/id_rsa_4096.pub ~/.ssh/id_rsa_4096.pub```
- ```chmod 600 ~/.ssh/id_rsa```
- ```chmod 600 ~/.ssh/id_rsa.pub```
- ```chmod 600 ~/.ssh/id_rsa_4096```
- ```chmod 600 ~/.ssh/id_rsa_4096.pub```

#### syncdb
- ```mkdir ~/.syncdb```
- ```cd ~/.syncdb```
- ```composer require vielhuber/syncdb```
- ```chmod +x vendor/vielhuber/syncdb/src/syncdb```
- ```ln -s /var/www/lamp/syncdb ~/.syncdb/profiles```
- ```sudo nano ~/.bash_profile```
- ```export PATH="$PATH:/root/.syncdb/vendor/vielhuber/syncdb/src"```
- ```source ~/.bash_profile ```

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

#### oraclesql

- sign in https://container-registry.oracle.com and accept TOS
- installation
  - ```docker login container-registry.oracle.com```
  - ```docker pull container-registry.oracle.com/database/enterprise:12.2.0.1```
  - ```docker run -dit -p 1521:1521 --name oracle_db container-registry.oracle.com/database/enterprise:12.2.0.1```
  - ```docker logs -f oracle_db``` # wait for "Done !" in logs
  - ```docker exec -it oracle_db bash -c "source /home/oracle/.bashrc; sqlplus /nolog"```
  - ```connect sys as sysdba;```
  - ```Oradoc_db1```
  - ```alter session set "_ORACLE_SCRIPT"=true;```
- create new user (=schema!)
  - ```create user root identified by root;```
  - ```GRANT ALL PRIVILEGES TO root;```
- start/stop:
  - Docker Desktop
- credentials:
  - ip: localhost
  - port: 1521
  - service name: ORCLCDB.localdomain
  - username: root
  - password: root
- tablespaces
  - view: ```SELECT tablespace_name, file_name, bytes / 1024/ 1024  MB FROM dba_data_files;```
  - create: ```CREATE TABLESPACE DATA1 DATAFILE 'DATA1.dbf' SIZE 10M AUTOEXTEND ON;```

#### ghostscript
- ```sudo apt-get install ghostscript```
- ```ghostscript -v```

#### imagemagick
- ```sudo apt-get install imagemagick imagemagick-doc```
- ```convert --version```
- ```sudo nano /etc/ImageMagick-6/policy.xml```
  - uncomment line ```<!-- <policy domain="coder" rights="none" pattern="MVG" /> -->```
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
- if an error like "Fontconfig warning: FcPattern object weight does not accept value [0.5 15.3)" appears, clear font cache: ```sudo fc-cache -f -v```

#### cpdf
- ```cd /opt/```
- ```wget https://github.com/coherentgraphics/cpdf-binaries/archive/master.zip```
- ```unzip master.zip```
- ```mv cpdf-binaries-master/Linux-Intel-64bit/cpdf /usr/local/bin/cpdf```
- ```rm -rf cpdf-binaries-master```
- ```rm master.zip```
- ```cpdf --help```

#### msgconvert
- ```sudo apt-get install libemail-outlook-message-perl```
- ```msgconvert --version```

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

#### webp (cwebp/dwebp)
- ```sudo apt-get install webp```
- ```cwebp -version```
- ```dwebp -version```

#### exiftool
- ```sudo apt-get install libimage-exiftool-perl```
- ```exiftool```

#### phpmyadmin
- ```mkdir /var/www/phpmyadmin```
- ```cd /var/www/phpmyadmin```
- ```composer create-project phpmyadmin/phpmyadmin .```
- ```lamp add phpmyadmin php8.0```
- ```cp config.sample.inc.php config.inc.php```
- ```nano config.inc.php```
  - ```$cfg['Servers'][$i]['user'] = 'root';```
  - ```$cfg['Servers'][$i]['AllowNoPassword'] = true;```
  - ```$cfg['Servers'][$i]['host'] = 'localhost';```
  - ```$cfg['Servers'][$i]['password'] = 'root';```
  - ```$cfg['Servers'][$i]['auth_type'] = 'config';```
  - ```$cfg['ExecTimeLimit'] = 6000;```
  - ```$cfg['blowfish_secret'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';``` (generate secret with: https://phpsolved.com/phpmyadmin-blowfish-secret-generator/?g=[insert_php]echo%20$code;[/insert_php])
- https://phpmyadmin.local.vielhuber.de
  - "Der phpMyAdmin-Konfigurationsspeicher ist nicht vollständig konfiguriert," => operations > create table

#### speedtest cli
- ```curl -s https://install.speedtest.net/app/cli/install.deb.sh | sudo bash```
- ```sudo apt-get install speedtest```

#### include windows fonts in linux
- ```ln -s /mnt/c/Windows/Fonts /usr/share/fonts/WindowsFonts```
- ```fc-cache```

#### clasp
- ```npm i @google/clasp -g```
- https://script.google.com/home/usersettings => enable
- ```npm i -S @types/google-apps-script```
- ```clasp login```

#### httrack
- ```sudo apt install httrack webhttrack```

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

#### youtube-dl
- ```sudo curl -L https://yt-dl.org/downloads/latest/youtube-dl -o /usr/local/bin/youtube-dl```
- ```sudo chmod a+rx /usr/local/bin/youtube-dl```
- ```youtube-dl --version```

#### inkscape
- ```sudo apt-get install inkscape```

#### rsvg
- ```sudo apt-get install librsvg2-bin```

#### xclip (pipe to clipboard)
- ```sudo apt-get install xclip```
- ```echo "foo" | xclip```

#### autostart
- wsl
  - Aufgabenplanung
  - "wsl"
  - Nur ausführen, wenn der Benutzer angemeldet ist
  - Trigger: Bei Anmeldung
  - Aktion: Programm starten (C:\Windows\System32\bash.exe -c "")
- services
  - Aufgabenplanung
  - "lamp"
  - Nur ausführen, wenn der Benutzer angemeldet ist
  - Trigger: Bei Anmeldung, verzögern für: 90 Sekunden
  - Aktion: Programm starten (\\wsl$\Ubuntu\var\www\lamp\start.bat)

#### wsl improve i/o performance
- https://medium.com/@leandrw/speeding-up-wsl-i-o-up-than-5x-fast-saving-a-lot-of-battery-life-cpu-usage-c3537dd03c74
- Windows Defender Security Center > Viren- & Bedrohungsschutz > Einstellungen für Viren- & Bedrohungsschutz > Ausschlüsse hinzufügen oder entfernen
  - Ordner: C:\Users\David\AppData\Local\Packages\CanonicalGroupLimited.UbuntuonWindows_79rhkp1fndgsc
  - Prozesse: git, node, dpkg, php5.6, php7.0, php7.1, php7.2, php7.3, php7.4, php8.0, php-fpm5.6, php-fpm7.0, php-fpm7.1, php-fpm7.2, php-fpm7.3, php-fpm7.4, php-fpm8.0, mysql, mysqld, apache2, bash, postgres, wkhtmltopdf

#### switch cli php version
- ```sudo update-alternatives --config php```
- ```sudo update-alternatives --set php /usr/bin/php7.4``` (directly set)
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
- ```lamp add project php8.0```
- ```lamp add project php8.0 custom/subfolder/public```
- ```lamp add project php8.0 custom/subfolder/public 3000```

#### remove project
- ```lamp remove project```