<?php
$url = "https://vielhuber.de";
$title = "David Vielhuber";
echo '<ul>';
    echo '<li><a class="facebook" target="_blank" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u='.urlencode($url).'">Facebook</a></li>';
    echo '<li><a class="xing" target="_blank" rel="nofollow" href="https://www.xing.com/app/user?op=share&amp;url='.urlencode($url).'">Xing</a></li>';
    echo '<li><a class="linkedin" target="_blank" rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&url='.urlencode($url).'&title='.urlencode($title).'&summary=&source=">LinkedIn</a></li>';
    echo '<li><a class="twitter" target="_blank" rel="nofollow" href="https://twitter.com/intent/tweet?url=&text='.urlencode($title.' - '.$url).'">Twitter</a></li>';
    if($image !== null ) {
        echo '<li><a class="pinterest" target="_blank" rel="nofollow" href="https://www.pinterest.de/pin/create/button/?url='.urlencode($url).'&media='.urlencode($image).'&description='.urlencode($title).'">Pinterest</a></li>';
    }
    echo '<li><a class="whatsapp" rel="nofollow" href="whatsapp://send?text='.urlencode($title.' - '.$url).'">WhatsApp</a></li>';
    echo '<li><a class="mail" rel="nofollow" href="mailto:?subject='.rawurlencode($title).'&body='.rawurlencode($url).'">E-Mail</a></li>';
echo '</ul>';