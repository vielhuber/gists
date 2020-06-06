<?php
set_transient('example_transient', 'foobar'); // store string forever
set_transient('example_transient', ['foo' => 'bar'], 60*60*24); // store array for 1 day
get_transient('example_transient'); // false if not exists
delete_transient('example_transient');
if( get_transient('example_transient') !== false ) { /* ... */ } // check existence
if( get_option('_transient_timeout_' . 'example_transient') < time() ) { /* ... */ } // check existence without getting the whole value