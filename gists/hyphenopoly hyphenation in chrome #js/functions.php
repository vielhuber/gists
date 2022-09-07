<?php
/* hyphenopoly */
add_action('wp_head', function()
{
    $lng = '';
    foreach(apply_filters( 'wpml_active_languages', null ) as $languages__value) {
        if ($languages__value['active']) { $lng = $languages__value['default_locale']; break; }
    }
    $lng = str_replace('_','-',$lng);
    $lng = strtolower($lng);
    ?>
    <script>
    let Hyphenopoly = {
        paths: {
            patterndir: '<?php echo get_bloginfo('template_directory'); ?>/hyphenopoly/patterns/',
            maindir: '<?php echo get_bloginfo('template_directory'); ?>/hyphenopoly/'
        },
        require: {
          	'<?php echo $lng; ?>': 'FORCEHYPHENOPOLY'
        },
      	/* see above! */
      	/* ... */
    };
    </script>
    <script src="<?php echo get_bloginfo('template_directory'); ?>/hyphenopoly/Hyphenopoly_Loader.js"></script>
    <style>
    body
    {
      	/* see above! */
      	/* ... */
    }
    </style>
    <?php
});