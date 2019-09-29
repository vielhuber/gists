<?php
// routes/web.php

Route::get('/backend', function() {
    event(new \App\Events\TestEvent([
		"foo" => "bar",
		"bar" => 1337
	]));
});

Route::get('/frontend', function() {
	?>
	<!DOCTYPE html>
	<head>
	  <script src="https://js.pusher.com/3.2/pusher.min.js"></script>
	  <script>
	    Pusher.logToConsole = true;
	    var pusher = new Pusher('334727ffbe0b3048ec8b', {
			cluster: 'eu',
			encrypted: false
	    });
	    var channel = pusher.subscribe('test-channel');
	    channel.bind('App\\Events\\TestEvent', function(data) {
	    	console.log(data);
	    });
	  </script>
	</head>
	<?php
});