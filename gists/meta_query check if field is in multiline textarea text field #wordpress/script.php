<?php
$wp_query = new \WP_Query([
    'meta_query' => [
        [
            'key' => 'foo',
            'value' => "((^)|(\r\n|\r|\n))bar((\r\n|\r|\n)|($))",
            'compare' => 'REGEXP'
        ]
    ],
]);