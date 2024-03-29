// current date
new Date();

// date from string
new Date('2016-01-01');

// date from string (german)
let str = '01.01.2016';
new Date(str.substring(6,10)+'-'+str.substring(3,5)+'-'+str.substring(0,2));

// current date with time 00:00:00
new Date(((new Date()).getFullYear()+'-'+('0'+((new Date()).getMonth()+1)).slice(-2)+'-'+('0'+(new Date()).getDate()).slice(-2))+' 00:00:00')
let d = new Date(); d.setHours(0); d.setMinutes(0); d.setSeconds(0); d.setMilliseconds(0); // alternative

// with time (use with "T" for cross browser support; be aware: safari does not support '2000-07-28 11:32:00' and also has problems with timezones)
new Date('2022-11-03T16:00:00+0'+Math.abs(new Date('2022-11-03').getTimezoneOffset() / 60)+':00');
new Date('<?php echo wp_date('Y-m-d\TH:i:sP', strtotime(get_gmt_from_date('2022-06-01 15:00:00'))); ?>'); // wordpress/php example

// convert time from Europe/Berlin to users local timezone
let datetime_from_db_in_europe_berlin = '2022-02-07 00:23:10';
let d = new Date(datetime_from_db_in_europe_berlin.replace(' ', 'T')+'+0'+Math.abs(new Date(datetime_from_db_in_europe_berlin.split(' ')[0]).getTimezoneOffset() / 60)+':00');
console.log(d); // test that by temporarily changing the timezone in the windows settings!

// convert time from users local timezone to Europe/Berlin
let datetime_in_users_timezone = '2022-02-07 00:23:10';
let d = new Date(datetime_in_users_timezone.replace(' ', 'T'));
d = d.toLocaleString('en-GB', { timeZone: 'Europe/Berlin' }).replace(',','');
d = new Date(d.substring(6,10)+'-'+d.substring(3,5)+'-'+d.substring(0,2)+'T'+d.substring(11,13)+':'+d.substring(14,16)+':'+d.substring(17,19));

// date from timestamp
new Date(1515107594 * 1000);

// php time() equivalent
Math.floor(new Date().getTime() / 1000)

// add years to date
function addYears(date, years)
{
  var result = new Date(date);
  result = new Date(result.setFullYear(result.getFullYear() + years));
  return result;
}

// add months to date
function addMonths(date, months)
{
  var result = new Date(date);
  result = new Date(result.setMonth(result.getMonth() + months));
  return result;
}

// add days to date
function addDays(date, days)
{
  var result = new Date(date);
  result.setDate(result.getDate() + days);
  return result;
}

// add hours to date
function addHours(date, hours) {   
   var result = new Date(date);
   result.setTime(result.getTime() + (hours*60*60*1000)); 
   return result;
}

// first day of current month
let d = new Date();
let d2 = new Date(d.getFullYear(), d.getMonth(), 1);

// last day of current month
let d = new Date();
let d2 = new Date(d.getFullYear(), d.getMonth() + 1, 0);

// first day of previous month
let d = new Date();
let d2 = new Date(d.getFullYear(), d.getMonth() - 1, 1);

// last day of previous month
let d = new Date();
let d2 = new Date(d.getFullYear(), d.getMonth(), 0);

// monday of current week
let d = new Date();
let d2 = new Date( d.setDate( d.getDate() - d.getDay() + (d.getDay() == 0 ? -6 : 1) ) );

// formatted date
var d = new Date();
('0'+d.getDate()).slice(-2)+'.'+('0'+(d.getMonth()+1)).slice(-2)+'.'+d.getFullYear()+' '+('0'+d.getHours()).slice(-2)+':'+('0'+d.getMinutes()).slice(-2)+':'+('0'+d.getSeconds()).slice(-2);

// without variable
('0'+(new Date()).getDate()).slice(-2)+'.'+('0'+((new Date()).getMonth()+1)).slice(-2)+'.'+(new Date()).getFullYear()+' '+('0'+(new Date()).getHours()).slice(-2)+':'+('0'+(new Date()).getMinutes()).slice(-2)+':'+('0'+(new Date()).getSeconds()).slice(-2);

// get current month name (es6)
(new Date()).toLocaleString('de-DE', { month: 'long' });

// get current month name (old)
['Januar','Februar','März','April','Mai','Juni','Juli','August','September','Oktober','November','Dezember'][(new Date()).getMonth()];

// get current day name
['Sonntag','Montag','Dienstag','Mittwoch','Donnerstag','Freitag','Samstag'][(new Date()).getDay()];

// get previous month
new Date((new Date()).getFullYear(), (new Date()).getMonth()-1, 1);

// datetime-local (2018-01-01T00:00:00)
(new Date()).getFullYear()+'-'+('0'+((new Date()).getMonth()+1)).slice(-2)+'-'+('0'+(new Date()).getDate()).slice(-2)+'T'+('0'+(new Date()).getHours()).slice(-2)+':'+('0'+(new Date()).getMinutes()).slice(-2)+':'+('0'+(new Date()).getSeconds()).slice(-2);

// get difference in seconds between two dates
let a = new Date('2000-07-28T11:32:00'),
    b = new Date('2000-07-28T11:38:00');
console.log(Math.abs(a-b)/(1000)); // 360

// compare times
Date.parse('01/01/2011 10:20:45') > Date.parse('01/01/2011 5:10:10') // 01/01/2011 is irrelevant

// compare dates
let d1 = new Date();
let d2 = new Date();
d1.setHours(5); d1.setMinutes(0); d1.setSeconds(0); d1.setMilliseconds(0);
d2.setHours(6); d2.setMinutes(5); d2.setSeconds(0); d2.setMilliseconds(0);
d1 < d2 // true
d1 > d2 // false
// be careful when comparing equality
d1.setHours(0);
d2.setHours(0);
d1 === d2 // wrong
d1 === d2 // wrong
d1.getTime() === d2.getTime() // sometimes wrong (because of milliseconds)
+d1 === +d2 // sometimes wrong (because of milliseconds)
+d1 >= +d2 // sometimes wrong (because of milliseconds)
+d1 <= +d2 // sometimes wrong (because of milliseconds)
d1.getFullYear() === d2.getFullYear() && d1.getMonth() === d2.getMonth() && d1.getDate() === d2.getDate() // best