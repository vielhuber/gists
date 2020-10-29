<?php
/* this solution is way better than the crappy js redirect of wpml (which leads to Page Speed issues) */
// only on root, and only if wpml
if ($_SERVER['REQUEST_URI'] == '/' && function_exists('icl_get_languages')) {
  	// disable caching
  	define('DONOTCACHEPAGE', true);
    // get all languages
    $available_languages = icl_get_languages('skip_missing=0');
    // set default
    $preferred_language = 'en';
    // set empty if it doesn't exist
    if (!array_key_exists('HTTP_ACCEPT_LANGUAGE', $_SERVER)) {
        $_SERVER['HTTP_ACCEPT_LANGUAGE'] = '';
    }
    $matches = [];
    foreach ($available_languages as $available_languages__key => $available_languages__value) {
        // HTTP_ACCEPT_LANGUAGE contains something like 'de,en-US;q=0.8,en;q=0.5,pt-BR;q=0.3'
        // only use 'pt' from 'pt-br'
        $pos = mb_strpos(mb_strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']), mb_substr($available_languages__key, 0, 2));
        // insert into matches array by position in string, so we know which is preferred
        // easier approach than going for quality-parameter
        if ($pos !== false) {
            $matches[$pos] = $available_languages__value;
        }
    }
    // choose one
    if (count($matches) > 0) {
        // sort matches by occurance
        ksort($matches);
        $preferred_language = $matches[key($matches)]['code'];
    }
    wp_redirect(site_url('/' . $preferred_language . '/'), 302);
    die();
}
