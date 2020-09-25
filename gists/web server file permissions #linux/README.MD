## ziel
- standardrechte 755/644 auf /var/www
- wp updates im backend, dateiänderung von überall aus möglich
- angemessene sicherheit: localhost kann weniger restriktiv sein als öffentlicher server

## shared hosts

- bei all inkl laufen apache, ssh, ftp, ... alle mit demselben user (nicht root!)
- die ordner und dateien haben standardrechte (755 für ordner, 644 für dateien)
- damit kann der user auf allen wegen überall schreiben und es gibt kein problem

## tools

- rsync kopiert file permissions! das ist meistens nicht gewollt, deshalb: `--no-perms --no-owner --no-group`
- git synchronisiert file permission änderungen (nicht owner/group)! das ist meistens nicht gewollt, deshalb: `git config --global core.filemode false`

#### #1: aktuellen user der www-data gruppe zuweisen (empfohlene lösung für öffentliche server)
- setup
  - `adduser $USER www-data` # add current user to www-data group
  - `chown -R $USER:group /var/www` # change user to current user and group to www-data group
  - `chmod g+rwx -R /var/www` # give group all permissions
  - `chmod g+s /var/www` # set group id (sticky bit), so that new files set the group www-data (and not the owners group)
- nachteile
  - rsync, git, ..., können rechte zerstören
  - im wordpress backend kommen warnungen (von z.B. w3 total cache), dass die standardrechte 755/644 nicht gesetzt sind
  
#### #2: php als root ausführen (empfohlene lösung für lokale entwicklungsumgebung)
- `chown -R root:root /var/www`
- `nano /etc/php/X.X/fpm/pool.d/www.conf`
  - `user = root`
  - `group = root`
- `nano /etc/init.d/php7.4-fpm`
  - `DAEMON_ARGS="-R --daemonize --fpm-config $CONFFILE"`
- `sudo service php7.4-fpm restart`
- hinweise: wir bearbeiten `/etc/init.d/php7.4-fpm` und nicht `/lib/systemd/system/php7.4-fpm.service`, da wsl service (init.d) statt systemctl (systemd) benutzt
  
#### #3: owner auf root, gruppe auf apache setzen (empfohlene lösung für sichere server)
- setup
  - man setzt die werte auf default werte (755, 644, root:www-data)
  - nun kann der apache (bewusst) nicht mehr schreiben
  - man gibt einzelnen ordnern schreibrechte ("uploads", "cache")
- nachteile
  - wordpress backend updates nicht mehr möglich
  - in den ordnern mit schreibrechten gibt es ggf. unterschiedliche rechte, was zu problemen führen kann (wordpress ansatz hier: ftp user credentials)

#### #4: apache als lokaler user ausführen
- setup
  - `nano /etc/apache2/envvars`
  - `export APACHE_RUN_USER=david`
  - `chown -R david:www-data /var/www`
- nachteile
  - wsl2 läuft standardmäßig als root

#### #5: posix acl (access control lists)
- setup
  - `setfacl -Rm d:u:userA:rwX,u:userA:rwX /var/www`
  - `setfacl -Rm d:u:userB:rwX,u:userB:rwX /var/www`
- nachteile
  - löst nicht das problem, wenn ein spezifischer user eine neue datei erstellt
  
#### #6: apache als root ausführen
- apache kann nicht als root ausgeführt werden (setzt man User=root in der config, muss man den kompletten apachen mit dem flag `BIG_SECURITY_HOLE` neu builden)