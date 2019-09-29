# list all cronjobs
crontab -l

# generate cronjobs
# http://crontab-generator.org/

# run a task on reboot
@reboot ~/script.sh

# edit cronjobs
export VISUAL=nano; crontab -e

# test cronjobs (set to every minute and log to file)
append "set -x" to beginning of script to show also commands
* * * * * ~/script.sh >/tmp/log.txt 2>&1
date
date

# make shell script executable
chmod +x script.sh

# restart cron
systemctl restart crond.service

# this is important: the cronjobs above are all for the current user
# if you want to run tasks for root, do this
sudo crontab -e
# etc.