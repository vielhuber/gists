// disable wp cron on xdebug sessions
if (function_exists('xdebug_is_debugger_active') && xdebug_is_debugger_active()) {
    define('DISABLE_WP_CRON', true);
}