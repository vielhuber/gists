// check
if( document.cookie !== undefined && document.cookie.indexOf('cookie_name') > -1 ) { }

// set
var d = new Date();
d.setTime(d.getTime() + (7*24*60*60*1000));
var expires = d.toUTCString();
document.cookie = 'cookie_name'+'='+encodeURIComponent('cookie_value')+'; '+'expires='+expires+'; path=/';

// set (in one line)
document.cookie = 'cookie_name'+'='+encodeURIComponent('cookie_value')+'; '+'expires='+((new Date((new Date()).getTime() + (7*24*60*60*1000))).toUTCString())+'; path=/';

// get
var cookie_match = document.cookie.match(new RegExp('cookie_name' + '=([^;]+)'));
if(cookie_match) { alert(decodeURIComponent(cookie_match[1])); }

// unset
document.cookie = 'cookie_name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/';