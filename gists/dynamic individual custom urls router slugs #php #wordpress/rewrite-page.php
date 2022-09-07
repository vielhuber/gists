<?php
/*
Template Name: custom-page
*/
// map this template to a page that has the slug "custom-page"
$rewrite = get_query_var('rewrite');
$rewrite = explode("/",$rewrite);
echo '<pre>';
print_r($rewrite);
echo '</pre>';
// do whatever you need to do
?>