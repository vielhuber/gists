<?php
// set
echo '<input name="foo" value="'.base64_encode(serialize(['bar' => 'baz'])).'" type="hidden" />';

// get
unserialize(base64_decode($_POST['foo']));