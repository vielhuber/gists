<?php
// register strings
add_action('admin_init', function()
{
    if(function_exists('pll_register_string'))
    {
        $registered_strings = [
            'inline' => [
                'Einzeiliger String',
            ],
            'multiline' => [
                'Mehrzeiliger String'
            ]
        ];
        update_option('polylang_registered_strings', $registered_strings);
        foreach($registered_strings['inline'] as $registered_strings__value)
        {
            pll_register_string($registered_strings__value, $registered_strings__value, 'custom');
        }
        foreach($registered_strings['multiline'] as $registered_strings__value)
        {
            pll_register_string($registered_strings__value, $registered_strings__value, 'custom', true);
        }
    }
});
// provide all language strings for javascript
add_action('wp_head', function()
{
    $registered_strings = get_option('polylang_registered_strings');
    if( $registered_strings != '' )
    {
        $registered_strings_json = [];
        foreach(['inline','multiline'] as $registered_strings__type)
        {
            foreach($registered_strings[$registered_strings__type] as $registered_strings__value)
            {
                $registered_strings_json[str_replace('"','\"',$registered_strings__value)] = str_replace('"','\"',pll__($registered_strings__value));
            }
        }
        echo '<script type="text/javascript">';
            echo 'var registered_strings = JSON.parse(\''.json_encode($registered_strings_json, JSON_HEX_APOS).'\');';
            echo 'function pll__(string) { if( registered_strings[string] !== undefined ) { return registered_strings[string]; } return string; }';
        echo '</script>';
    }
},-1);
// you now can get translated strings in js the same way as in php:
pll__('Einzeiliger String');


// one time export of all untranslated strings
add_action('wp_head', function()
{
    if( 1==0 )
    {
        echo '<table>';
        $registered_strings = get_option('polylang_registered_strings');
        $languages = [];
        foreach(pll_the_languages(['raw'=>1]) as $languages__value)
        {
            $languages[] = $languages__value['slug'];
        }
        echo '<tr>';
        foreach($languages as $languages__value)
        {
            echo '<td>';
                echo $languages__value;
            echo '</td>';
        }
        echo '</tr>';
        if( $registered_strings != '' )
        {
            foreach(['inline','multiline'] as $registered_strings__type)
            {
                foreach($registered_strings[$registered_strings__type] as $registered_strings__value)
                {
                    $exists = false;
                    foreach($languages as $languages__value)
                    {
                        if( $languages__value != 'de' && $registered_strings__value === pll_translate_string($registered_strings__value, $languages__value) )
                        {
                            $exists = true;
                        }
                    }
                    if( $exists === true )
                    {
                        echo '<tr>';
                        foreach($languages as $languages__value)
                        {
                            echo '<td>';
                                echo pll_translate_string($registered_strings__value, $languages__value);
                            echo '</td>';
                        }
                        echo '</tr>';
                    }
                }
            }
        }
        echo '</table>';
        die();
    }
},-1);