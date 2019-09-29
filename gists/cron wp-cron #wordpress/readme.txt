/* put this in wp-config.php */
define('DISABLE_WP_CRON', true);

/* if you use variant 2, you also need to set DOCUMENT_ROOT on CLI in wp-config.php */
if( !isset($_SERVER['DOCUMENT_ROOT']) || $_SERVER['DOCUMENT_ROOT'] == '' )
{
    $_SERVER['DOCUMENT_ROOT'] = dirname(__FILE__);
}

/* add cronjob via shell (run every hour) */
crontab -l
export VISUAL=nano; crontab -e

/* variant 1 */
0 * * * * wget https://www.tld.com/wp-cron.php >/dev/null 2>&1

/* variant 2 */
0 * * * * php /var/www/html/project/wp-cron.php >/dev/null 2>&1