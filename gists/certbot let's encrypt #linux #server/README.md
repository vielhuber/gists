#### install
```
sudo add-apt-repository ppa:certbot/certbot
sudo apt install python-certbot-apache
```

#### add new for existing non ssl host
```
certbot --apache -d www.tld.org tld.org
// this automatically creates the file /etc/httpd/conf.modules.d/tld.org-le-ssl.conf
systemctl restart httpd
```

#### check renew
```
certbot renew --dry-run
export VISUAL=nano; crontab -e
30 2 * * * /usr/bin/certbot renew >> /var/log/le-renew.log
```

#### delete
```
sudo certbot delete
manually delete conf files in /etc/httpd/conf.modules.d/*
```