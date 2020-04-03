<?php
/* wp manual solution: place this in head BEFORE analytics is embedded */
add_action('wp_head', function()
{
    echo "<script>var disableStr = 'ga-disable-'+'UA-XXXXXXXX-1'; if( document.cookie.indexOf(disableStr + '=true') > -1 ) { window[disableStr] = true; } document.addEventListener('DOMContentLoaded', function() { document.addEventListener('click', function(e) { if( e.target.tagName === 'A' && e.target.getAttribute('href') === '#ga-disable' ) { alert('OK!'); document.cookie = disableStr + '=true; expires=Thu, 31 Dec 2099 23:59:59 UTC; path=/'; window[disableStr] = true; e.preventDefault(); } }, true); });</script>".PHP_EOL;
},-1000);

/* wp plugin solution: when using the plugin "Google Analytics Dashboard for WP" */
add_action('wp_head', function()
{
    echo "<script>document.addEventListener('DOMContentLoaded', function() { document.addEventListener('click', function(e) { if( e.target.tagName === 'A' && e.target.getAttribute('href') === '#ga-disable' ) { alert('OK!'); __gaTrackerOptout(); } }, true); });</script>".PHP_EOL;
},-1000);