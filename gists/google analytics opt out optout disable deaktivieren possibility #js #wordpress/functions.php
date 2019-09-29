<?php
/* with manual embed */
add_action('wp_head', function()
{
    echo "<script>var disableStr = 'ga-disable-'+'UA-XXXXXXXX-1'; if( document.cookie.indexOf(disableStr + '=true') > -1 ) { window[disableStr] = true; } document.addEventListener('DOMContentLoaded', function() { document.addEventListener('click', function(e) { if( e.target.tagName === 'A' && e.target.getAttribute('href') === '#ga-disable' ) { alert('OK!'); document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/'; window[disableStr] = true; e.preventDefault(); } }, true); });</script>".PHP_EOL;
},-1000);

/* when using the plugin Google Analytics Dashboard for WP and enabled option "aktiviere die Unterstützung für den Benutzer-Opt-Out" */
add_action('wp_head', function()
{
    echo "<script>document.addEventListener('DOMContentLoaded', function() { document.addEventListener('click', function(e) { if( e.target.tagName === 'A' && e.target.getAttribute('href') === '#ga-disable' ) { if (typeof gaOptout === 'function') { gaOptout(); } alert('OK!'); e.preventDefault(); } }, true); });</script>".PHP_EOL;
},-1000);