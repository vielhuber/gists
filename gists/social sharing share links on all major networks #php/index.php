<?php
$url = 'https://vielhuber.de';
$url = 'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$title = 'David Vielhuber';
$image = 'https://vielhuber.de/wp-content/themes/vielhuber/_assets/about.jpg';
echo '<ul>';
    echo '<li><a class="facebook" target="_blank" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'" title="Facebook">Facebook</a></li>';
    echo '<li><a class="xing" target="_blank" rel="nofollow" href="https://www.xing.com/app/user?op=share&amp;url='.urlencode($url).'" title="Xing">Xing</a></li>';
    echo '<li><a class="linkedin" target="_blank" rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($url).'&title='.urlencode($title).'&summary=&source=" title="LinkedIn">LinkedIn</a></li>';
    echo '<li><a class="twitter" target="_blank" rel="nofollow" href="https://twitter.com/intent/tweet?url=&text='.urlencode($title.' - '.$url).'" title="X (Twitter)">X (Twitter)</a></li>';
    if($image !== null ) {
        echo '<li><a class="pinterest" target="_blank" rel="nofollow" href="https://www.pinterest.de/pin/create/button/?url='.urlencode($url).'&media='.urlencode($image).'&description='.urlencode($title).'" title="Pinterest">Pinterest</a></li>';
    }
    echo '<li><a class="whatsapp" rel="nofollow" href="whatsapp://send?text='.urlencode($title.' - '.$url).'" title="WhatsApp">WhatsApp</a></li>';
    echo '<li><a class="mail" rel="nofollow" href="mailto:?subject='.rawurlencode($title).'&body='.rawurlencode($url).'" title="E-Mail">E-Mail</a></li>';
echo '</ul>';