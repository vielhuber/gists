### list all cronjobs

```crontab -l```

### generate cronjobs

- https://crontab-generator.org

### run a task on reboot

```@reboot ~/script.sh```

### edit cronjobs

```export VISUAL=nano; crontab -e```

### test cronjobs (set to every minute and log to file)

- nano ```/tmp/crontab-test.sh```
```sh
#!/bin/bash
set -x
date
```
- make script executable: ```chmod +x /tmp/crontab-test.sh```
- add this to crontab: ```* * * * * /tmp/crontab-test.sh >/tmp/crontab-log.txt 2>&1```
- test script: ```/tmp/crontab-test.sh``` and ```/tmp/crontab-test.sh >/tmp/crontab-log.txt 2>&1```
- check the log: ```tail -f /tmp/crontab-log.txt```

### make shell script executable

```chmod +x script.sh```

### restart cron

```systemctl restart crond.service```

### user

this is important: the cronjobs above are all for the current user
if you want to run tasks for root, do this
```sudo crontab -e```
etc.