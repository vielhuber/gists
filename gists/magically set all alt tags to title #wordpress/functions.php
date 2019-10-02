add_action('after_setup_theme', function() {
    ob_start(function($html) {
        $html = magic_alt($html);
        return $html; 
    });
});
add_action('shutdown', function() {
    ob_end_flush();
});


function magic_alt($html)
{
    if(preg_match('/<title>(.+)<\/title>/i', $html, $matches1))
    {
        $title = $matches1[1];
        // first replace <img src="" alt /> with <img src="" alt="" />
        if(preg_match_all('/<img(?![^>]*\balt=)[^>]*?>/', $html, $matches2))
        {
            $replacings = [];
            foreach($matches2[0] as $matches2__key=>$matches2__value)
            {
                $new = str_replace('alt ', 'alt=""', $matches2__value);
                $replacings[] = [$matches2__value, $new];
            }
            foreach($replacings as $replacings__value)
            {
                $html = str_replace($replacings__value[0],$replacings__value[1],$html);
            }
        }
        if(preg_match_all('/<img ((.|\n)*?)alt="(.*?)"((.|\n)*?)>/', $html, $matches3))
        {
            $replacings = [];
            foreach($matches3[0] as $matches3__key=>$matches3__value)
            {
                $alt = $matches3[3][$matches3__key];
                // don't optimize
                if( mb_strlen($alt) > 100 ) { continue; }
                $pos1 = strpos($matches3__value, ' alt="')+mb_strlen(' alt="');
                $pos2 = $pos1+mb_strlen($alt);
                $new = substr($matches3__value, 0, $pos1) . $title . substr($matches3__value, $pos2);
                $replacings[] = [$matches3__value, $new];
            }
            foreach($replacings as $replacings__value)
            {
                $html = str_replace($replacings__value[0],$replacings__value[1],$html);
            }
        }
    }
    return $html;
}