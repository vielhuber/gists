<?php
// headers
header('Content-type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename=' . "calendar.ics");

// helper functions
function formatDateICS($date) {
	if( strpos($date," ") !== false && strpos($date,":") !== false ) {
		return date('Ymd\THis', strtotime($date));
	}
	else {
		return date('Ymd', strtotime($date));
	}
}

// prepare appointments
$appointment = array(
	array(
		"ID" => 1, // unique appointment ID
		"title" => "Begrenzter Termin",
		"start" => "2015-09-29 08:00",
		"end" => "2015-09-29 09:00"
	),
	array(
		"ID" => 2,
		"title" => "Ganztagestermin",
		"start" => "2015-09-30"
	),
);

// set up output
$output = "";

$output .= "BEGIN:VCALENDAR
METHOD:PUBLISH
VERSION:2.0
PRODID:-//Company Name//Kalender Name//DE\n";
 
foreach($appointment as $ap) {
$output .= "BEGIN:VEVENT
SUMMARY:".$ap["title"]."
UID:".$ap["ID"]."
STATUS:CONFIRMED
DTSTART:".formatDateICS($ap["start"])."\n";
if(isset($ap["end"])) { $output .= "DTEND:".formatDateICS($ap["end"])."\n"; }
$output .= "END:VEVENT\n";
}
 
$output .= "END:VCALENDAR";
 
// output
echo $output; 
die();
?>