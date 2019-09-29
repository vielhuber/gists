<?php
/* hyphenopoly */
add_action('wp_head', function()
{
    ?>
    <script>
    let Hyphenopoly = {
        paths: {
            patterndir: '<?php echo get_bloginfo('template_directory'); ?>/hyphenopoly/patterns/',
            maindir: '<?php echo get_bloginfo('template_directory'); ?>/hyphenopoly/'
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