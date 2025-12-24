<?php
add_action('wp_head_top', function()
{
    if(!is_user_logged_in())
    {
        foreach([
            '/example-url-1/' => '12345678-1',
            '/example-url-2/' => '12345678-2'
        ] as $ab_tests__key=>$ab_tests__value)
        {
            if(
                strpos(
                    'http'.((isset($_SERVER['HTTPS'])&&$_SERVER['HTTPS']!=='off')?'s':'').'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
                    site_url().$ab_tests__key
                ) === 0
                &&
                strpos(
                    $_SERVER['REQUEST_URI'],
                    'ab_test=b'
                ) === false
            )
            {
                ?>
                <!-- Google Analytics Content Experiment code -->
                <script>function utmx_section(){}function utmx(){}(function(){var
                k='<?php echo $ab_tests__value; ?>',d=document,l=d.location,c=d.cookie;
                if(l.search.indexOf('utm_expid='+k)>0)return;
                function f(n){if(c){var i=c.indexOf(n+'=');if(i>-1){var j=c.
                indexOf(';',i);return escape(c.substring(i+n.length+1,j<0?c.
                length:j))}}}var x=f('__utmx'),xx=f('__utmxx'),h=l.hash;d.write(
                '<sc'+'ript src="'+'http'+(l.protocol=='https:'?'s://ssl':
                '://www')+'.google-analytics.com/ga_exp.js?'+'utmxkey='+k+
                '&utmx='+(x?x:'')+'&utmxx='+(xx?xx:'')+'&utmxtime='+new Date().
                valueOf()+(h?'&utmxhash='+escape(h.substr(1)):'')+
                '" type="text/javascript" charset="utf-8"><\/sc'+'ript>')})();
                </script><script>utmx('url','A/B');</script>
                <!-- End of Google Analytics Content Experiment code -->
                <?php
            }
        }
    }
});