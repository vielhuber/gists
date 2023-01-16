<?php
if(isset($_POST["delete"]) && !empty($_POST["delete"])) {
  $id = key($_POST["delete"]);
  // ...
  die();
}

$obj = array(
  1 => "foo",
  2 => "bar"
);
echo '<form method="post">';
foreach($obj as $o) {
  ?><input type="button" onclick="return false;" ondblclick="jQuery('<input />').attr('type', 'hidden').attr('name', jQuery(this).attr('name')).attr('value', 'tmp').appendTo( jQuery(this).closest('form') ); jQuery(this).closest('form').submit();" name="delete[<?php echo $f; ?>]" value="X" /><?php
}
echo '</form>';
?>