## features

- wsl2 + ubuntu 24
- simple installation
- simple usage via command line
- full control over configuration
- systemd enabled
- cronjobs enabled
- default remote smtp relay for all mailings
- databases included: mysql (+phpmyadmin), postgresql, oraclesql
- shared php.ini configuration for all versions
- switch php/cli version (globally and host based)
- access via all devices in your local network
- support for different networks
- real ssl certificates for all hosts and all registry.npmjs.orgdevices
- supports reverse proxy configuration
- native linux performance (can handle node_modules and vendor) with wsl2
- php debugging and profiling with xdebug

## installation

#### hosts

##### internal wifi (e.g. cloudflare)

- we abuse our own public domain as a dns that maps to a local ip in order to prevent setting local hosts AND having the ability to access via smartphones/tablets from the same network
- dns a-records
  - vielhuber.dev => 192.168.0.2
  - *.vielhuber.dev => 192.168.0.2
- fritzbox (if needed)
  - fritz.box > Heimnetz > Netzwerk > Netzwerkeinstellungen > DNS-Rebind-Schutz:
    - vielhuber.de
    - vielhuber.dev
    - *.vielhuber.dev
  - restart

##### public (cloudflare)

- `curl -fsSL https://pkg.cloudflare.com/cloudflare-main.gpg | sudo tee /usr/share/keyrings/cloudflare-main.gpg >/dev/null
echo 'deb [signed-by=/usr/share/keyrings/cloudflare-main.gpg] https://pkg.cloudflare.com/cloudflared jammy main' | sudo tee /etc/apt/sources.list.d/cloudflared.list`
- `sudo apt-get update`
- `sudo apt-get install cloudflared`
- `cloudflared tunnel login`
- `cloudflared tunnel create TUNNEL`
- `cloudflared tunnel route dns --overwrite-dns TUNNEL rebuhleiv.xyz`
// admin interface is on cloudflare.com > Zero Trust > Networks > Tunnels
- `cloudflared tunnel run --url http://localhost:8000 TUNNEL`

##### local based

- run powershell as adminstrator
- `PowerShell -Command "Set-ExecutionPolicy RemoteSigned -scope Process; iwr -useb https://raw.githubusercontent.com/gerardog/gsudo/master/installgsudo.ps1 | iex"`
- uncomment `"/mnt/c/Users/David/apps/gsudo/gsudo.exe" -d "echo 127.0.0.1 $PROJECT.vielhuber.dev >> %windir%\System32\drivers\etc\hosts"` from `lamp`

#### open firewall
- not used, because we use firewall.ps1 (see below)
- ~~Windows Defender Firewall mit erweiterter Sicherheit~~
- ~~Eingehende Regeln > Neue Regel > Port > TCP > 80, 443~~

#### wsl2
- open PowerShell as admin
- wsl --install
- Windows Store > "Ubuntu"
  - available versions: https://blogs.msdn.microsoft.com/commandline/2018/07/09/upgrading-ubuntu/
  - we use the plain "Ubuntu" version and upgrade it inplace with `sudo do-release-upgrade`
- UNIX username: root (cancel when prompting for a new default username)
- Change password with ```passwd```: "root"
- Netzlaufwerk "\\wsl$\Ubuntu" auf W: mappen und umbenennen: "WSL"
- `wsl --list --verbose`
- `wsl --set-default-version 2`
- `wsl --set-version Ubuntu 2`
- `wsl --setdefault Ubuntu`
- `wsl --list --verbose`

#### backup/restore wsl2
- Run PowerShell as admin
- `wsl --shutdown`
- `wsl --list`
- `wsl --export "Ubuntu" D:\Ubuntu.tar`
- `wsl --import "Ubuntu" D:\ D:\Ubuntu.tar`

#### upgrade to latest ubuntu
- `wsl --update` # kernel upgrade
- `sudo apt-get update --allow-releaseinfo-change`
- `sudo apt-get upgrade`
- `sudo apt dist-upgrade`
- `sudo apt autoremove`
- `sudo apt clean`
- `sudo do-release-upgrade`
  - If this hangs: `sudo apt remove snapd`
- `lsb_release -a`

#### move to another drive
- `mkdir D:\backup`
- `wsl --export Ubuntu D:\backup\ubuntu.tar`
- `wsl --unregister Ubuntu`
- `mkdir D:\wsl`
- `mkdir D:\wsl\ubuntu-latest`
- `wsl --import Ubuntu D:\wsl\ubuntu-latest\ D:\backup\ubuntu.tar`
- `wsl --setdefault Ubuntu`

#### optional: use multiple wsl instances
- `wsl --import Ubuntu-1 D:\wsl\ubuntu-1\ D:\backup\ubuntu-1.tar`
- `wsl --import Ubuntu-2 D:\wsl\ubuntu-2\ D:\backup\ubuntu-2.tar`
- ...

#### increase disk size
- https://docs.microsoft.com/en-us/windows/wsl/vhd-size
- Powershell (Admin)
  - `wsl --shutdown`
  - `Get-AppxPackage -Name "*Ubuntu*" | Select PackageFamilyName`
  - if default: `C:\Users\David\AppData\Local\Packages\CanonicalGroupLimited.UbuntuonWindows_79rhkp1fndgsc\LocalState\ext4.vhdx`
  - if moved: `D:\wsl\ubuntu-latest\ext4.vhdx`
- CMD (Admin)
  - `diskpart`
  - `Select vdisk file="D:\wsl\ubuntu-latest\ext4.vhdx"`
  - `detail vdisk`
  - `expand vdisk maximum=416000`
  - `exit`
- WSL
  - `sudo mount -t devtmpfs none /dev`
  - `mount | grep ext4` # note sdX (where X = a|b|c)
  - `sudo resize2fs /dev/sdc 416000M`
  - `df -h`
  
#### prevent password prompt for sudo commands
- ```sudo visudo```
- comment out ```%sudo ALL=(ALL:ALL) ALL```
- ```%sudo ALL=(ALL:ALL) NOPASSWD:ALL```

#### install basic linux packages
- ```sudo apt-get install nano curl sshpass zip unzip htop ruby libnotify-bin net-tools pv csh cifs-utils apt-utils software-properties-common iputils-ping gettext```

#### disable nginx
- `sudo systemctl disable nginx`
- `sudo systemctl disable --now nginx`

#### redis
- ```sudo apt-get -y install redis-server```
- ```sudo systemctl start redis-server```
- ```sudo systemctl enable redis-server```
- ```redis-cli```
- ```sudo systemctl restart redis.service```
- ```redis-cli ping```

#### docker
- Option #1 (with gui in windows)
  - Download Docker desktop: https://hub.docker.com/editions/community/docker-ce-desktop-windows/
  - Installation: "Install required Windows components for WSL 2"
  - Login with account
  - Settings > General > "Use the WSL 2 based engine"
  - Settings > Resources -> WSL Integration -> "Enable integration with my default WSL distro", 
  - Test inside WSL
    - ```docker version```
    - ```docker compose version```
- Option #2 (run docker natively inside wsl)
  - Install exactly like on `https://docs.docker.com/engine/install/ubuntu/`

#### xserver (deprecated and therefore not needed anymore; now included in wslg!)
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
  - "_VCXSRV"
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

#### wslg (wsl gui)
- change theme
  - `sudo apt install gnome-tweaks`
  - `gnome-tweaks`
    - Appearance > Applications: HighContrastInverse
    - Window Titlebars > Maximize / Minimize
    - Fonts > Scaling Factor > 0.75
  - Falls es nicht geöffnet wird, WSL neustarten
- fix glitches
  - updated nvidia drivers (via "GeForce Experience")
  - ```sudo apt update```
  - ```sudo apt upgrade```
  - ```wsl --shutdown```

#### systemd
  - `nano /etc/wsl.conf`
  - `[boot]`
  - `systemd=true`
  - cmd (admin): `wsl --shutdown`
  - `systemctl status`

#### ngrok

```
curl -sSL https://ngrok-agent.s3.amazonaws.com/ngrok.asc \
  | sudo tee /etc/apt/trusted.gpg.d/ngrok.asc >/dev/null \
  && echo "deb https://ngrok-agent.s3.amazonaws.com buster main" \
  | sudo tee /etc/apt/sources.list.d/ngrok.list \
  && sudo apt update \
  && sudo apt install ngrok
```

- `ngrok help`

- single domain:
  - `ngrok config add-authtoken AUTH_TOKEN`
  - `ngrok http 8080 --url DEV_DOMAIN`
- multiple domains/ports:
  - `ngrok config edit`

```
- tunnels:
  api1:
    addr: 8080
    schemes:
      - https
    proto: http
  api2:
    addr: 8931
    schemes:
      - https
    proto: http
```

  - `ngrok start --all`

- open the dev domains once and accept the button once

#### nvidia cuda

- https://developer.nvidia.com/cuda-downloads?target_os=Linux&target_arch=x86_64&Distribution=WSL-Ubuntu&target_version=2.0&target_type=deb_local
- `wget https://developer.download.nvidia.com/compute/cuda/repos/wsl-ubuntu/x86_64/cuda-wsl-ubuntu.pin`
- `sudo mv cuda-wsl-ubuntu.pin /etc/apt/preferences.d/cuda-repository-pin-600`
- `wget https://developer.download.nvidia.com/compute/cuda/12.8.1/local_installers/cuda-repo-wsl-ubuntu-12-8-local_12.8.1-1_amd64.deb`
- `sudo dpkg -i cuda-repo-wsl-ubuntu-12-8-local_12.8.1-1_amd64.deb`
- `sudo cp /var/cuda-repo-wsl-ubuntu-12-8-local/cuda-*-keyring.gpg /usr/share/keyrings/`
- `sudo apt-get update`
- `sudo apt-get -y install cuda-toolkit-12-8`
- `sudo nano ~/.bash_profile`
- `export PATH=/usr/local/cuda/bin${PATH:+:${PATH}}`
- `export LD_LIBRARY_PATH=/usr/local/cuda/lib64${LD_LIBRARY_PATH:+:${LD_LIBRARY_PATH}}`
- `source ~/.bash_profile`
- `nvidia-smi`
- `nvcc --version`

#### vscode
- install Remote - WSL Installieren
- Erweiterungen > Wolke: Lokale Erweiterungen in WSL - Ubuntu installieren > Alle markieren
- Innerhalb von WSL ausführen: `code .`

#### smartgit
- `cd /usr/local`
- `rm -rf ./smartgit`
- `wget https://downloads.syntevo.com/downloads/smartgit/smartgit-linux-24_1_2.tar.gz`
- `tar xzf smartgit-linux-*.tar.gz`
- `rm smartgit-linux-*.tar.gz`
- `nano /usr/local/bin/sgit`
- `( /usr/local/smartgit/bin/smartgit.sh & ) > /dev/null 2>&1`
- `chmod +x /usr/local/bin/sgit`
- `sgit`
- Register existing license: /var/www/lamp/syntevo-non-commercial.lic
- User Name: David Vielhuber
- Email: david@vielhuber.de
- Use SmartGit as SSH client
- Style: Working tree (file oriented)
- Window > Repositories bis Output (alles anklicken/anzeigen)
- Edit > Preferences > Allow modifying pushed commits (e.g. forced-push)
- Edit > Preferences > User Interface > Dark (independent of system)
- Edit > Preferences > User Interface > On start-up: Don't reopen the last used repositories
- Edit > Preferences > User Interface > Built-in Text Editors > Font Size: 9
- Edit > Preferences > Git Config > Fetch and Pull > Rebase local branch onto fetched changes
- Pro Repository: AI Button > ChatGPT API Key hinterlegen
- Repository > Search for Repositories > /var/www
- Manuelles Umbenennen falscher Namen ("www - ...", gtbabel 3x)
- Optional: Alle Repositories: Rechte Maustaste: Mark as favorite (dies erhöht Performance durch Background Refresh)
- Wenn non-commercial Lizenz abläuft:
  - https://www.syntevo.com/register-non-commercial/ > register with github
  - alternative: rm -rf ~/.config/smartgit/ > download/install/use v21
- Wenn es Probleme mit GTK gibt:
  - ```nano ~/.config/smartgit/smartgit.vmoptions```, ```swtver=4932``` hinzufügen
- Falls Updateprozess innerhalb des Programms scheitert:
  - Einfach neue tar.gz downloaden, entzippen (und bestehende Dateien überschreiben)

#### hide intro text
- ```touch ~/.hushlogin```

#### pimp command line
- ```sudo nano ~/.bash_profile```
```
# colorize and show git branch name
alias ls='ls --color'
LS_COLORS='di=1:fi=0:ln=31:pi=5:so=5:bd=5:cd=5:or=31:mi=0:ex=35:*.rpm=90'
export LS_COLORS
parse_git_branch() { git branch 2> /dev/null | sed -e '/^[^*]/d' -e 's/* \(.*\)/(\1)/'; }
parse_git_tag() { git describe --exact-match --tags 2> /dev/null | sed -e 's/\(.*\)/[\1]/'; }
PS1='${debian_chroot:+($debian_chroot)}\[\033[01;32m\]\u\[\033[00m\]@\[\033[01;31m\]\h\[\033[00m\]~\[\e[0;36m\]\t\[\033[00m\]~\[\033[01;34m\]\w\[\033[01;31m\]$(parse_git_branch)\[\033[01;33m\]$(parse_git_tag)\[\033[00m\]\$ '
```
- ```source ~/.bash_profile```

#### apache/php/mysql
- ```sudo apt-get install apache2 mysql-server```
- ```sudo systemctl start apache2```
- ```sudo systemctl start mysql```
- ```sudo systemctl enable apache2```
- ```sudo systemctl enable mysql```
- run mysql_secure_installation
  - the following steps fixes this error: https://www.digitalocean.com/community/tutorials/how-to-install-mysql-on-ubuntu-22-04#step-2-configuring-mysql
  - ```sudo mysql```
  - ```ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'root';```
  - ```exit```
  - ```sudo mysql_secure_installation```
    - Validate password plugin: n
    - mysql-root-Passwort: root
    - Remove anonymous users: y
    - Disallow root login remotely: n
    - Remove test database: y
    - Reload privilege tables: y
  - ```mysql -u root -p```
  - ```ALTER USER 'root'@'localhost' IDENTIFIED WITH auth_socket;```
  - ```exit```
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
- ```sudo apt-get install -y php8.1 php8.1-fpm libapache2-mod-php8.1 php8.1-mysql php8.1-cli php8.1-common php8.1-xdebug php8.1-mbstring php8.1-xmlrpc php8.1-gd php8.1-intl php8.1-xml php8.1-mysql php8.1-zip php8.1-soap php8.1-curl php8.1-bcmath php8.1-xml php8.1-sqlite php8.1-imap php8.1-opcache php8.1-pgsql php8.1-pdo php8.1-gd php8.1-imagick```
- ```sudo apt-get install -y php8.2 php8.2-fpm libapache2-mod-php8.2 php8.2-mysql php8.2-cli php8.2-common php8.2-xdebug php8.2-mbstring php8.2-xmlrpc php8.2-gd php8.2-intl php8.2-xml php8.2-mysql php8.2-zip php8.2-soap php8.2-curl php8.2-bcmath php8.2-xml php8.2-sqlite php8.2-imap php8.2-opcache php8.2-pgsql php8.2-pdo php8.2-gd php8.2-imagick```
- ```sudo apt-get install -y php8.3 php8.3-fpm libapache2-mod-php8.3 php8.3-mysql php8.3-cli php8.3-common php8.3-xdebug php8.3-mbstring php8.3-xmlrpc php8.3-gd php8.3-intl php8.3-xml php8.3-mysql php8.3-zip php8.3-soap php8.3-curl php8.3-bcmath php8.3-xml php8.3-sqlite php8.3-imap php8.3-opcache php8.3-pgsql php8.3-pdo php8.3-gd php8.3-imagick```
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
- ```sudo systemctl restart apache2```

#### configs
- setup with presets from [dbf3d6844b3e6159d6b7](https://gist.github.com/vielhuber/dbf3d6844b3e6159d6b7)
- ```sudo nano /etc/mysql/mysql.conf.d/mysqld.cnf```
- ```sudo nano /etc/apache2/apache2.conf```
- ```sudo nano /etc/php/X.X/fpm/pool.d/www.conf``` (important❗)
- ~```sudo nano /etc/php/X.X/apache2/php.ini```~ (not needed, see below)
- ~```sudo nano /etc/php/X.X/cli/php.ini```~ (not needed, see below)

#### setup default page
- ```sudo a2dissite 000-default.conf```
- ```nano /etc/apache2/sites-available/000-blank.conf```

```
<VirtualHost *:80>
  DocumentRoot /var/www
  <Directory /var/www>
    Options +Indexes
    AllowOverride None
    Require all granted
  </Directory>
</VirtualHost>
<VirtualHost *:443>
  DocumentRoot /var/www
  <Directory /var/www>
    Options +Indexes
    AllowOverride None
    Require all granted
  </Directory>
  SSLEngine on
  SSLCertificateFile /etc/letsencrypt/live/vielhuber.dev/fullchain.pem
  SSLCertificateKeyFile /etc/letsencrypt/live/vielhuber.dev/privkey.pem
</VirtualHost>
```

- ```sudo a2ensite 000-blank.conf```
- ```sudo systemctl reload apache2```
- test https://foo.vielhuber.dev / http://192.168.0.2

#### ssl
- `sudo apt install certbot python3-certbot-dns-cloudflare`
- `pip install --upgrade pyOpenSSL cryptography certbot certbot-dns-cloudflare`
- `mkdir -p ~/.secrets/certbot`
- `nano ~/.secrets/certbot/cloudflare.ini`
- `dns_cloudflare_api_token = YOUR_CLOUDFLARE_API_TOKEN_WITH_EDIT_ZONE_DNS_PERMISSIONS`
- `chmod 600 ~/.secrets/certbot/cloudflare.ini`
- `certbot certonly --dns-cloudflare --dns-cloudflare-credentials ~/.secrets/certbot/cloudflare.ini -d '*.vielhuber.dev' -d vielhuber.dev --agree-tos --email david@vielhuber.de --dns-cloudflare-propagation-seconds 60 --non-interactive`
- `certbot renew --dry-run`
- `sudo mv /etc/cron.d/certbot /etc/cron.d/certbot.disabled`
- `export VISUAL=nano; crontab -e`
- `0 12 * * * certbot renew --quiet`

#### powershell

- `sudo apt-get update`
- `sudo apt-get install -y wget apt-transport-https software-properties-common`
- `source /etc/os-release`
- `wget -q https://packages.microsoft.com/config/ubuntu/$VERSION_ID/packages-microsoft-prod.deb`
- `sudo dpkg -i packages-microsoft-prod.deb`
- `rm packages-microsoft-prod.deb`
- `sudo apt-get update`
- `sudo apt-get install -y powershell`
- `pwsh`

#### postfix
- ```sudo apt-get install postfix```
   - General type: "Internet Site"
   - System mail name: "vielhuber.de"
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
- ```sudo systemctl restart postfix```
- ```sudo systemctl restart rsyslog```
- ```sudo systemctl enable postfix```
- ```sudo systemctl enable rsyslog```
- ```echo "Das ist ein Test" | mail -s "Test bestanden" -a "From: smtp@vielhuber.de" david@vielhuber.de```
- ```sudo nano /etc/php/custom.ini```
  - ```sendmail_path = "/usr/sbin/sendmail -t -i"```

#### ncdu
- ```sudo apt-get install ncdu```
- ```cd /```
- ```ncdu --exclude /mnt```

#### node + php + python auto version switching on cd
- ```nano ~/.bash_profile```
- https://gist.github.com/vielhuber/021453a7e908f9487917835107ad6ce7
- ```source ~/.bash_profile```
- now place `.nvmrc` / `.phprc` with the version (e.g. `12.10.0` / `8.1`) in the folder, where your `package.json` / `composer.json` lays and `.envrc` with `venv` (or your environment name)

#### php error logging
- ```touch /var/log/php-error.log```
- ```chmod +x /var/log/php-error.log```
- in combination with ```error_log``` in php.ini logging now works for both php fpm (this is always the case for specific versions) and php as an apache module (this is always the case for general version)

#### create xdebug profile output dir
- ```mkdir -p /tmp/xdebug```

#### shared php.ini configuration
- ```sudo nano /etc/php/custom.ini```
```
user_ini.filename =

max_execution_time = 4800
max_input_time = 900
post_max_size = 800M
memory_limit = 4096M
upload_max_filesize = 800M
max_input_vars = 100000
max_file_uploads = 5000
realpath_cache_size = 4M
;allow_url_include = On
;allow_url_fopen = On
date.timezone = 'Europe/Berlin'
display_errors = On
error_log = /var/log/php-error.log
;error_reporting = E_ALL & ~E_NOTICE
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
; we set this to 1 so that we can set revalidate_freq on a project basis to a higher value
opcache.validate_timestamps=1
opcache.revalidate_freq=2

[xdebug]
; mode (see: https://xdebug.org/docs/all_settings#mode)
;   reasonable default
xdebug.mode=debug,profile
;   disabled
;xdebug.mode=off
;   step debugging
;xdebug.mode=debug
;   performance profiling (be aware of load/space)
;xdebug.mode=profile
;   trace profiling (record args)
;xdebug.mode=trace

; starting mode
;   always (not recommended)
;xdebug.start_with_request=yes
;   only when specific get parameters / cookies are set
;   (?XDEBUG_TRIGGER=1, ?XDEBUG_PROFILE=1, ?XDEBUG_TRACE=1, ?XDEBUG_SESSION=1)
;   this is best in conjunction with Chrome extension "Xdebug helper"
xdebug.start_with_request=trigger
;   folder for analyzing profile dumps
xdebug.output_dir="/tmp/xdebug"
;   not needed, since it is already in /etc/php/7.4/fpm/conf.d/20-xdebug.ini
;zend_extension=xdebug.so
```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.1/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.2/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.3/apache2/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.1/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.2/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.3/fpm/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/5.6/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.0/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.1/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.2/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.3/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/7.4/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.0/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.1/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.2/cli/conf.d/custom.ini```
- ```ln -s /etc/php/custom.ini /etc/php/8.3/cli/conf.d/custom.ini```

#### local environment permissions
- reset
  - `chown -R root:root /var/www`
  - `chmod 00755 /var`
  - `chmod 00755 /var/www`
  - `find /var/www -type d -exec chmod 00755 {} \;`
  - `find /var/www -type f -exec chmod 00644 {} \;`
- run php as root
  - `nano /etc/php/5.6/fpm/pool.d/www.conf`
  - `nano /etc/php/7.0/fpm/pool.d/www.conf`
  - `nano /etc/php/7.1/fpm/pool.d/www.conf`
  - `nano /etc/php/7.2/fpm/pool.d/www.conf`
  - `nano /etc/php/7.3/fpm/pool.d/www.conf`
  - `nano /etc/php/7.4/fpm/pool.d/www.conf`
  - `nano /etc/php/8.0/fpm/pool.d/www.conf`
  - `nano /etc/php/8.1/fpm/pool.d/www.conf`
  - `nano /etc/php/8.2/fpm/pool.d/www.conf`
  - `nano /etc/php/8.3/fpm/pool.d/www.conf`
    - **be aware: comment out with ";" instead of "#" :)**
      - `user = root`
      - `group = root`
  - `nano /etc/init.d/php5.6-fpm`
  - `nano /etc/init.d/php7.0-fpm`
  - `nano /etc/init.d/php7.1-fpm`
  - `nano /etc/init.d/php7.2-fpm`
  - `nano /etc/init.d/php7.3-fpm`
  - `nano /etc/init.d/php7.4-fpm`
  - `nano /etc/init.d/php8.0-fpm`
  - `nano /etc/init.d/php8.1-fpm`
  - `nano /etc/init.d/php8.2-fpm`
  - `nano /etc/init.d/php8.3-fpm`
    - `DAEMON_ARGS="-R --daemonize --fpm-config $CONFFILE"`
  - `sudo systemctl edit php5.6-fpm`
  - `sudo systemctl edit php7.0-fpm`
  - `sudo systemctl edit php7.1-fpm`
  - `sudo systemctl edit php7.2-fpm`
  - `sudo systemctl edit php7.3-fpm`
  - `sudo systemctl edit php7.4-fpm`
  - `sudo systemctl edit php8.0-fpm`
  - `sudo systemctl edit php8.1-fpm`
  - `sudo systemctl edit php8.2-fpm`
  - `sudo systemctl edit php8.3-fpm`
    - Oberhalb einfügen:
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm5.6 -R --nodaemonize --fpm-config /etc/php/5.6/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm7.0 -R --nodaemonize --fpm-config /etc/php/7.0/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm7.1 -R --nodaemonize --fpm-config /etc/php/7.1/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm7.2 -R --nodaemonize --fpm-config /etc/php/7.2/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm7.3 -R --nodaemonize --fpm-config /etc/php/7.3/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm7.4 -R --nodaemonize --fpm-config /etc/php/7.4/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm8.0 -R --nodaemonize --fpm-config /etc/php/8.0/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm8.1 -R --nodaemonize --fpm-config /etc/php/8.1/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm8.2 -R --nodaemonize --fpm-config /etc/php/8.2/fpm/php-fpm.conf`
    - `[Service]`
    - `ExecStart=`
    - `ExecStart=/usr/sbin/php-fpm8.3 -R --nodaemonize --fpm-config /etc/php/8.3/fpm/php-fpm.conf`
  - `systemctl restart php5.6-fpm`
  - `systemctl restart php7.0-fpm`
  - `systemctl restart php7.1-fpm`
  - `systemctl restart php7.2-fpm`
  - `systemctl restart php7.3-fpm`
  - `systemctl restart php7.4-fpm`
  - `systemctl restart php8.0-fpm`
  - `systemctl restart php8.1-fpm`
  - `systemctl restart php8.2-fpm`
  - `systemctl restart php8.3-fpm`
  - `systemctl enable php5.6-fpm`
  - `systemctl enable php7.0-fpm`
  - `systemctl enable php7.1-fpm`
  - `systemctl enable php7.2-fpm`
  - `systemctl enable php7.3-fpm`
  - `systemctl enable php7.4-fpm`
  - `systemctl enable php8.0-fpm`
  - `systemctl enable php8.1-fpm`
  - `systemctl enable php8.2-fpm`
  - `systemctl enable php8.3-fpm`

#### fix small wsl warnings
- ```sudo nano /etc/apache2/apache2.conf```
- AcceptFilter https none
- AcceptFilter http none
- ```sudo systemctl stop mysql```
- ```sudo usermod -d /var/lib/mysql/ mysql```

#### fix font errors
- if fonts are garbled: ```sudo fc-cache -f -v```

#### fix wsl2 errors
- apache not reachable
  - \\wsl$\Ubuntu\var\www\lamp\firewall.ps1 anlegen mit Inhalt von https://github.com/microsoft/WSL/issues/4150#issuecomment-504209723
  - Ports in Datei erweitern: ```$ports=@(80,443,10000,3000,3009,5000,8080,9090,3306);```
  - Aufgabenplanung
  - "_WSL FIREWALL"
  - Bei Anmeldung
  - Verzögern für 10 Minuten
  - Programm starten
  - PowerShell.exe -File \\wsl$\Ubuntu\var\www\lamp\firewall.ps1
  - Mit höchsten Privilegien ausführen
  - OBSOLET: etc/hosts: 172.31.142.215 ***.vielhuber.de
  - OBSOLET: Oder alternativ bei DF von 192.168.0.2 auf 172.31.142.215 setzen (muss ich später wieder rückgängig machen!)
  - OBSOLET: etc/hosts: #127.0.0.1      localhost und #::1             localhost einkommentieren
- php error
  - `mkdir -p /run/php/`
- /tmp clean
  - `find /tmp -ctime +2 -exec rm -rf {} +`
- DISABLED: run startup scripts
  - `/etc/wsl.conf`
  - `[boot]`
  - `command="/var/www/lamp/start.sh >> /var/www/lamp/start.log 2>&1"`
- DISABLED: disable PATH import on WSL
  - Don't do this, since `code .` etc. does not work anymore
  - `/etc/wsl.conf`
  - `[interop]`
  - `appendWindowsPath=false`
- remove zone identifier files
  - `find . -name "*:Zone.Identifier" -type f -delete`
- ram overload
  - you need a lot of ram on your machine
  - create `%UserProfile%\.wslconfig`
  ```
  [wsl2]
  memory=24GB # choose a reasonable amount of ram (over 10GB), which your local machine has free all the time
  #swap=16GB # not needed
  localhostForwarding=true
  ```
- wsl hangs after a while / vscode hangs
  - Docker > Settings > Start Docker Desktop when you log in: aus
  - NOT USED: WIN+R > SystemPropertiesAdvanced > Erweitert > Leistung > Einstellungen... > Erweitert > Virtueller Arbeitsspeicher > Ändern... > Dateigröße für alle Laufwerke automatisch verwalten: aus & C: > Benutzerdefinierte Größe: 800 MB - 1024 MB; CMD als Admin: wmic computersystem where name="%computername%" set AutomaticManagedPagefile=false

#### enable cron
- `sudo systemctl enable cron`

#### restart router / pc
- `export VISUAL=nano; crontab -e`
- `0 4 * * * source $HOME/.bash_profile; /mnt/c/Users/David/OneDrive/DOCS/VODAFONE/cron.sh > /mnt/c/Users/David/OneDrive/DOCS/VODAFONE/cron.log 2>&1`
- `cron.sh`
```sh
#!/usr/bin/env bash
/root/.nvm/versions/node/v23.5.0/bin/node --env-file=/mnt/c/Users/David/OneDrive/DOCS/VODAFONE/.env /mnt/c/Users/David/OneDrive/DOCS/VODAFONE/stagehand.js
shutdown.exe /s /t 0
```

#### sync bills
- `export VISUAL=nano; crontab -e`
- `0 3 * * 1 source $HOME/.bash_profile; /usr/bin/wget "https://vielhuber.dev/wp-content/themes/vielhuber/_bills/sync.php" >/dev/null 2>&1`

#### make backups
- `export VISUAL=nano; crontab -e`
- `0 2 * * 0 /mnt/c/Users/David/OneDrive/DOCS/PROJEKTE/FACHLEHRER/BACKUP/script.sh > /mnt/c/Users/David/OneDrive/DOCS/PROJEKTE/FACHLEHRER/BACKUP/script.log`

#### composer
- ```sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"```
- ```sudo php composer-setup.php```
- ```sudo php -r "unlink('composer-setup.php');"```
- ```sudo mv composer.phar /usr/local/bin/composer```
- hide sudo message:
  - ```sudo nano ~/.bash_profile```
  - ```# hide composer sudo message```
  - ```export COMPOSER_ALLOW_SUPERUSER=1```
  - ```source ~/.bash_profile```
- ```composer self-update```
- ```composer --version``` # 2
- ```composer config --global --auth github-oauth.github.com *TOKEN*``` (siehe Zugangsdaten)

#### node / npm
- nvm
  - ```sudo curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.3/install.sh | bash```
  - copy 3 new lines of ```~/.bashrc``` to ```~/.bash_profile``` (because .bashrc is not loaded on wsl)
  - restart terminal
  - ```nvm --version```
  - ```nvm ls```
  - install/upgrade new/specific node versions
    - ```nvm install node```
    - ```nvm install --lts```
    - ```nvm install 16.17.0```
    - ```nvm install 14.18.0```
    - ```nvm install 12.10.0```
    - ```nvm install 10.16.3```
    - ```nvm alias default 16.17.0```
    - ```nvm use 16.17.0```
  - install/upgrade to latest npm version (do this for every installed node version)
    - ```nvm install-latest-npm && nvm install --latest-npm```
  - upgrade lts
    - ```nvm uninstall --lts```
    - ```nvm install --lts```
    - ```nvm use --lts```
  - Cache leeren (falls sich package-lock.json ändert: `npm cache verify` bzw `npm cache clean -f`)
- nativ (obsolet)
  - https://nodejs.org/en/download/package-manager/#debian-and-ubuntu-based-linux-distributions
  - ```curl -sL https://deb.nodesource.com/setup_12.x | sudo -E bash -```
  - ```sudo apt-get install -y nodejs```
  - ```sudo apt-get install -y build-essential```
- prevent permission errors / download errors
  - method 1:
    - `npm cache verify`
    - `npm cache clean -force`
    - `rm -rf node_modules`
    - `rm package-lock.json`
  - method 2 (not working):
    - `nano ~/.npmrc`
```
#registry=http://registry.npmjs.org/
#strict-ssl=false
#unsafe-perm=true
```
- install ncu
  - ```npm install -g npm-check-updates```
- login npm
  - ```export BROWSER=none && npm login```

#### yarn
- ```corepack enable```
- ```corepack prepare yarn@stable --activate```
- ```yarn --version```

#### python
- install python 3.X
  - ```sudo apt-get update```
  - ```sudo apt-get install python3 python3-pip python3-venv```
  - ```python3 --version```
  - ```pip3 --version```
- install python 2.X
  - ```sudo apt-get install python2```
  - ```python2 --version```
- change default version
  - ```cd /usr/bin```
  - ```sudo rm python```
  - ```ln -s ./python3 ./python```

#### blackfire.io php debugger
- ```wget -q -O - https://packages.blackfire.io/gpg.key | sudo dd of=/usr/share/keyrings/blackfire-archive-keyring.asc```
- ```echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/blackfire-archive-keyring.asc] http://packages.blackfire.io/debian any main" | sudo tee /etc/apt/sources.list.d/blackfire.list```
- ```sudo apt update```
- ```sudo apt install blackfire```
- ```sudo blackfire agent:config --server-id=xxx --server-token=xxx``` (see blackfire.io)
- ```sudo systemctl restart blackfire-agent```
- ```sudo systemctl enable blackfire-agent```
- ```sudo apt install blackfire-php```
- ```blackfire config --client-id=xxx --client-token=xxx``` (see blackfire.io)
- ```blackfire run ./vendor/bin/phpunit```

#### go
- `sudo apt-get install golang`
- `go version`

#### gettext
- ```sudo apt-get install gettext```
- ```msgfmt --help```

#### gulp
- ```npm install --global gulp-cli```

#### git
- ```sudo add-apt-repository ppa:git-core/ppa -y```
- ```sudo apt-get update```
- ```sudo apt-get install git -y```
- ```git --version```
- ```git config --global core.ignorecase false```
- ```git config --global core.filemode false```
- ```git config --global core.autocrlf input``` # this converts everything to lf on commit, which is ok when using wsl2 (however, there are projects where you want it to be the default value of `false`, set that with `git config core.autocrlf false`)
- ```git config --global core.safecrlf false```
- ```git config --global push.default simple```
- ```git config --global user.name "David Vielhuber"```
- ```git config --global user.email "david@vielhuber.de"```
- ```git config --global pull.rebase true``` # this means `git pull` does always `git pull --rebase`!
- ```git config --global core.mergeoptions --no-edit``` # prevent editor on merge
- ```git config --global init.defaultBranch main```
- ```git config set advice.skippedCherryPicks false```
- further do this (--no-edit does sometimes not work):
  - ```sudo nano ~/.bash_profile```
  - ```export GIT_MERGE_AUTOEDIT=no```
- node 10 hangs (https://stackoverflow.com/questions/45433130/npm-install-gets-stuck-at-fetchmetadata/72391698#72391698)
  - ```sudo nano ~/.gitconfig```
  - ```[url "https://"]```
  - ```   insteadOf = git://```
- sign commits/tags with ssh key
  - `git config --global gpg.format ssh`
  - `git config --global user.signingkey ~/.ssh/id_rsa.pub`
  - `git config --global commit.gpgsign true`
  - `git config --global tag.gpgsign true`
  - `git config --global push.gpgsign true`
  - GitHub > Settings > SSH and GPG keys > New SSH key > Key type: Signing Key + id_rsa.pub
- commit hooks
  - `git config --global core.hooksPath ~/git-template/hooks`
  - ai
    - `nano ~/git-template/hooks/prepare-commit-msg`
    - Script von https://vielhuber.de/blog/git-commit-messages-mit-chatgpt/
    - `chmod +x ~/git-template/hooks/prepare-commit-msg`
  - filesize
    - `nano ~/git-template/hooks/pre-commit`
    - `chmod +x ~/git-template/hooks/pre-commit`

```
#!/usr/bin/env bash
set -euo pipefail
LIMIT_BYTES=$((100 * 1024 * 1024)) # 100 mb
failed=0
while IFS= read -r -d '' path; do
  size_bytes="$(git cat-file -s ":$path" 2>/dev/null || echo 0)"
  if (( size_bytes >= LIMIT_BYTES )); then
    echo "⛔: '$path' ist $((size_bytes / 1024 / 1024)) MiB (Limit: 100 MiB). git restore --staged \"$path\"" >&2
    failed=1
  fi
done < <(git diff --cached --diff-filter=AM --name-only -z)
exit "$failed"
```

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
- ```git clone git@bitbucket.org:lamp-xyz-git/lamp.git . --config core.autocrlf=false```
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
- ```sudo sh -c 'echo "deb http://apt.postgresql.org/pub/repos/apt $(lsb_release -cs)-pgdg main" > /etc/apt/sources.list.d/pgdg.list'```
- ```wget -qO- https://www.postgresql.org/media/keys/ACCC4CF8.asc | sudo tee /etc/apt/trusted.gpg.d/pgdg.asc &>/dev/null```
- ```sudo apt update```
- ```sudo apt-get install postgresql postgresql-contrib```
- sudo nano /etc/postgresql/15/main/postgresql.conf
  - listen_addresses = '*'
  - port = 5432
- PANIC: could not flush dirty data
  - sudo nano /etc/postgresql/15/main/postgresql.conf
  - data_sync_retry = on
- ```sudo systemctl start postgresql```
- ```sudo systemctl enable postgresql```
- ```sudo -u postgres psql```
- ```\password postgres```
- root
- ```\q```
- ```nano ~/.pgpass```
- ```*:5432:*:postgres:root```
- ```chmod 0600 ~/.pgpass```
- sudo nano /etc/postgresql/15/main/pg_hba.conf
```
# comment out all other lines and append this
local   all   postgres                  md5
local   all   all                       md5
host    all   all        127.0.0.1/32   md5
host    all   all        ::1/128        md5
```

#### postgres: upgrade to newest version (example from 15 to 17)
- `sudo apt-get install postgresql postgresql-contrib`
- `pg_lsclusters`
- `sudo pg_dropcluster 15 main --stop`
- `sudo pg_upgradecluster -v 17 15 main`
- redo the config settings mentionned above (with folder `/17/`)

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

- do this beforehand
  - remove old installations
    - `sudo rm -f /usr/local/bin/magick /usr/local/bin/convert`
    - `sudo rm -rf /usr/local/lib/ImageMagick-* /usr/local/etc/ImageMagick-7`
    - `apt remove "*imagemagick*" --purge -y && apt autoremove --purge -y`
  - fix cmake
    - `sudo rm /usr/local/bin/cmake`
    - `sudo apt-get remove cmake`
    - `sudo apt-get update`
    - `cmake --version`
    - `sudo apt-get install cmake`
  - install opencl headers
    - `sudo apt-get install -y ocl-icd-opencl-dev opencl-headers`
```
t=$(mktemp) && \
wget 'https://dist.1-2.dev/imei.sh' -qO "$t" && \
bash "$t" && \
rm "$t"
```
- ```convert -version```
- ```sudo nano /usr/local/etc/ImageMagick-7/policy.xml```
- add/edit
  - ```<policy domain="coder" rights="none" pattern="MVG" />```
  - ```<policy domain="coder" rights="read|write" pattern="PDF" />```
  - ```<policy domain="coder" rights="read|write" pattern="LABEL" />```

#### pdftk
- ```sudo apt update```
- ```sudo apt install pdftk```
- ```pdftk --version```

#### wkhtmltopdf
- ```sudo apt-get install libfontconfig1 libxrender1 xfonts-75dpi xfonts-base```
- ```cd /tmp/```
- ```mkdir dl```
- ```cd dl```
- ```wget https://github.com/wkhtmltopdf/packaging/releases/download/0.12.6.1-2/wkhtmltox_0.12.6.1-2.jammy_amd64.deb```
- ```sudo dpkg -i wkhtmltox_0.12.6.1-2.jammy_amd64.deb```
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

#### pdfinfo
- ```sudo apt-get install poppler-utils```
- ```pdfinfo```

#### tesseract
- ```sudo apt install tesseract-ocr```
- ```sudo apt install libtesseract-dev```
- ```sudo apt-get install tesseract-ocr-deu```
- ```tesseract --version```

#### msgconvert
- ```sudo apt-get install libemail-outlook-message-perl```
- ```msgconvert --version```

#### jpegoptim
- ```sudo apt-get install jpegoptim```
- ```jpegoptim --version```

#### mozjpeg
- ```sudo apt-get update```
- ```sudo apt-get install -y cmake autoconf automake libtool nasm make pkg-config git libpng-dev```
- ```cd /tmp/```
- ```mkdir mozjpeg```
- ```cd mozjpeg```
- ```wget https://github.com/mozilla/mozjpeg/archive/refs/tags/v4.1.1.tar.gz```
- ```tar -xzvf v*.tar.gz```
- ```cd mozjpeg-*/```
- ```mkdir build && cd build```
- ```sudo cmake -G"Unix Makefiles" ../```
- ```sudo make install```
- ```ln -s /opt/mozjpeg/bin/jpegtran /usr/bin/mozjpeg```
- ```cd ..```
- ```cd ..```
- ```cd ..```
- ```rm -rf mozjpeg```
- ```mozjpeg --version```

#### pngquant
- ```sudo apt-get install pngquant```
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
- ```wget https://www.lcdf.org/gifsicle/gifsicle-1.93.tar.gz```
- ```tar -xzvf gifsicle*.tar.gz```
- ```cd gifsicle*/```
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
- ```lamp add phpmyadmin php8.3```
- ```cp config.sample.inc.php config.inc.php```
- ```nano config.inc.php```
  - ```$cfg['Servers'][$i]['user'] = 'root';```
  - ```$cfg['Servers'][$i]['AllowNoPassword'] = true;```
  - ```$cfg['Servers'][$i]['host'] = 'localhost';```
  - ```$cfg['Servers'][$i]['password'] = 'root';```
  - ```$cfg['Servers'][$i]['auth_type'] = 'config';```
  - ```$cfg['ExecTimeLimit'] = 6000;```
  - ```$cfg['blowfish_secret'] = 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx';``` (generate secret with: `openssl rand -base64 22`)
- https://phpmyadmin.vielhuber.dev
  - "Der phpMyAdmin-Konfigurationsspeicher ist nicht vollständig konfiguriert," => Anklicken + Erzeugen

#### speedtest cli
- ```curl -s https://packagecloud.io/install/repositories/ookla/speedtest-cli/script.deb.sh | sudo bash```
- ```sudo apt-get install speedtest```
- ```speedtest```

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
- ```gpg --recv-keys 409B6B1796C275462A1703113804BB82D39DC0E3 7D2BAF1CF37B13E2069D6956105BD0E739499BDB```
- ```echo 'export rvm_prefix="$HOME"' > /root/.rvmrc```
- ```echo 'export rvm_path="$HOME/.rvm"' >> /root/.rvmrc```
- ```curl -sSL https://get.rvm.io | bash -s stable```
- ```source ~/.rvm/scripts/rvm```
- ```rvm install ruby-3.1.2```
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
- ```cd /tmp```
- ```wget https://github.com/BtbN/FFmpeg-Builds/releases/download/latest/ffmpeg-master-latest-linux64-gpl-shared.tar.xz```
- ```tar -xf ffmpeg-*-shared.tar.xz```
- ```cd ffmpeg-*-shared```
- ```sudo cp bin/ffmpeg bin/ffprobe /usr/local/bin/```
- ```sudo cp -r lib/* /usr/local/lib/```
- ```sudo ldconfig```
- ```cd ..```
- ```rm -rf ffmpeg-*-shared*```
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

#### whatweb

- `mkdir whatweb`
- `cd whatweb`
- `git clone https://github.com/urbanadventurer/WhatWeb.git .`
- `sudo apt install -y ruby ruby-dev ruby-bundler build-essential make libssl-dev zlib1g-dev libyaml-dev`
- `sudo make install`

```
whatweb \
    --user-agent "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36" \
    -a 3 \
    -v \
    https://vielhuber.de
```

#### docker-osx
- installation
  - edit `%UserProfile%\.wslconfig`
    - `nestedVirtualization=true`
  - `sudo apt-get install kvm`
    - `kvm-ok` // KVM acceleration can be used
  - `sudo apt install x11-apps -y`
  - if port is in use
    - show used ports in powershell: `netsh int ipv4 show excludedportrange protocol=tcp`
    - change port in command below from 50922 to 40922
  - `docker run -it --name docker-osx --device /dev/kvm -p 40922:10022 -v /mnt/wslg/.X11-unix:/tmp/.X11-unix -e "DISPLAY=${DISPLAY:-:0.0}" -e GENERATE_UNIQUE=true -e MASTER_PLIST_URL='https://raw.githubusercontent.com/sickcodes/osx-serial-generator/master/config-custom.plist' sickcodes/docker-osx:ventura`
  - Disk Utility > QEMU HARDDISK Media (biggest) > Erase > Name: MyDockyOSX + Scheme: Mac OS Extended (Journaled)
  - Reinstall macOS Ventura
- run
  - `docker start docker-osx`

#### autostart (beides deaktiviert)
- wsl (deaktiviert)
  - Aufgabenplanung
  - "_WSL"
  - Nur ausführen, wenn der Benutzer angemeldet ist
  - Trigger: Bei Anmeldung
  - Aktion: Programm starten (C:\Windows\System32\bash.exe -c "")
- services (deaktiviert)
  - Aufgabenplanung
  - "_LAMP"
  - Nur ausführen, wenn der Benutzer angemeldet ist
  - Trigger: Bei Anmeldung, verzögern für: 7 Minuten
  - Aktion: Programm starten (\\wsl$\Ubuntu\var\www\lamp\start.bat)

#### wsl improve i/o performance
- https://medium.com/@leandrw/speeding-up-wsl-i-o-up-than-5x-fast-saving-a-lot-of-battery-life-cpu-usage-c3537dd03c74
- Windows-Sicherheit > Viren- & Bedrohungsschutz > Einstellungen für Viren- & Bedrohungsschutz > Ausschlüsse hinzufügen oder entfernen
  - Ordner: D:\wsl\ubuntu-latest
  - Prozesse: git, node, dpkg, php5.6, php7.0, php7.1, php7.2, php7.3, php7.4, php8.0, php8.1, php8.2, php8.3, php-fpm5.6, php-fpm7.0, php-fpm7.1, php-fpm7.2, php-fpm7.3, php-fpm7.4, php-fpm8.0, php-fpm8.1, php-fpm8.2, php-fpm8.3, mysql, mysqld, apache2, bash, postgres, wkhtmltopdf

#### switch cli php version
- ```sudo update-alternatives --config php```
- ```sudo update-alternatives --set php /usr/bin/php8.1``` (directly set)
- always choose manual mode (so newer installed versions do not get taken automatically)
- ```php -v```
- ```/usr/bin/php --version```
- ```/usr/bin/php8.2 --version``` (call specific cli version)

#### switch global php version
- ```sudo a2dismod phpY.Y```
- ```sudo a2enmod phpX.X```

#### switch clients
- you can setup lamp on multiple clients
- option 1: point the dns record to the current active client (currently used)
- option 2: setup a more dynamic approach like 01.project-name.vielhuber.dev, 02.project-name.vielhuber.dev, ...

## usage

#### restart wsl

- open cmd / ps as admin
- `wsl.exe --shutdown`
- `wsl.exe`

#### start
- ```lamp start```

#### restart
- ```lamp restart```

#### stop
- ```lamp stop```

#### create project
- ```lamp add project-name``` # uses default php version
- ```lamp add project-name php8.1``` # uses specific php version
- ```lamp add project-name php8.1 custom/subfolder/public``` # uses specific folder
- ```lamp add project-name php8.1 custom/subfolder/public --port=3000``` # uses specific port
- ```lamp add project-name php8.1 custom/subfolder/public --alias=rebuhleiv.xyz``` # sets alias for public usage (e.g. via cloudflare tunnel)

#### remove project
- ```lamp remove project```