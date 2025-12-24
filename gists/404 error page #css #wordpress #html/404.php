<?php
get_header();
    echo '<div class="_404">';
      echo '<div class="_404__inner">';
        echo '<h2 class="_404__title">';
          echo '404';
        echo '</h2>';
        echo '<a class="_404__link" href="'.get_bloginfo('url').'">';
          echo 'home';
        echo '</a>';
      echo '</div>';
    echo '</div>';
get_footer();