<?php
// alternative to js version
add_filter( 'the_content', function($content) {
    $content = str_replace('<table','<div class="responsive-table-container"><table',$content);
    $content = str_replace('</table>','</table></div>',$content);
    return $content;
}, -10);

// if you have ACF, simply use the filer acf_the_content!
add_filter( 'acf_the_content', function($content) { /* ... */ }