<?php
require_once(__DIR__ . '/vendor/autoload.php');

echo '
<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" />
        <title>.</title>
    </head>
    <body>
    ';

    $response = __curl(
        'https://www.googleapis.com/customsearch/v1',
        [
            'q' => 'Seite', // search term
            'start' => '1', // used for pagination
            'cx' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx', // search engine ID (obtained from https://programmablesearchengine.google.com)
            'key' => 'xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx' // api key (obtained from https://console.developers.google.com)
        ],
        'GET'
    );
    if( !empty($response->result->items) ) {
        echo '<ul>';
        foreach($response->result->items as $items__value) {
            echo '<li>';
                echo '<h2>'.$items__value->htmlTitle.'</h2>';
                echo '<a href="'.$items__value->link.'">'.$items__value->link.'</a>';
                echo '<p>'.$items__value->htmlSnippet.'</p>';
                if( !empty($items__value->pagemap->cse_thumbnail) ) {
                    echo '<img src="'.$items__value->pagemap->cse_thumbnail[0]->src.'" alt="" />';
                }
            echo '</li>';
        }
        echo '</ul>';
    }
    else {
        echo 'Keine Resultate gefunden.';
    }

    echo '
    </body>
</html>
';