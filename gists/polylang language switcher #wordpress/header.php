<?php
$language_switcher = pll_the_languages(['raw' => 1]);
echo '<div class="language_switcher">';
  echo '<ul class="language_switcher__list">';
  foreach($language_switcher as $language_switcher__value)
  {
    echo '<li class="language_switcher__item'.(($language_switcher__value['current_lang']=='1')?(' language-switcher__item--active'):('')).'">';
      echo '<a href="'.$language_switcher__value['url'].'">';
      	echo $language_switcher__value['slug'];
      echo '</a>';
    echo '</li>';
  }
  echo '</ul>';
echo '</div>';