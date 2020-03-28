// check
if( document.cookie !== undefined && document.cookie.indexOf('cookie_name') > -1 ) { }

// set
var d = new Date();
d.setTime(d.getTime() + (7*24*60*60*1000));
var expires = d.toUTCString();
var samesite = window.location.protocol.indexOf('https') > -1 ? '; SameSite=None; Secure' : '';
document.cookie = 'cookie_name'+'='+encodeURIComponent('cookie_value')+'; '+'expires='+expires+'; path=/'+samesite;

// set (in one line)
document.cookie = 'cookie_name'+'='+encodeURIComponent('cookie_value')+'; '+'expires='+((new Date((new Date()).getTime() + (7*24*60*60*1000))).toUTCString())+'; path=/'+(window.location.protocol.indexOf('https') > -1 ? '; SameSite=None; Secure' : '');

// get
var cookie_match = document.cookie.match(new RegExp('cookie_name' + '=([^;]+)'));
if(cookie_match) { alert(decodeURIComponent(cookie_match[1])); }

// unset
document.cookie = 'cookie_name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/'+(window.location.protocol.indexOf('https') > -1 ? '; SameSite=None; Secure' : '');

// note on samesite
- recommendation: set SameSite=None AND Secure on https sites to avoid third party cookie errors
- warning: also unsetting cookies needs the samesite argument
- this is needed on chrome >= 80
