<?php
// action *before* mail send
add_action( 'wpforms_process', function( $fields, $entry, $form_data ) {
    if (strpos(@$form_data['settings']['form_title'], 'Newsletter') === false) {
        return;
    }
    // do custom logic
    //print_r($fields);
    // show response error
    wpforms()->process->errors[$form_data['id']]['header'] = esc_html__('Es ist ein spezieller Fehler aufgetreten.', 'domain');
    return;
}, 10, 3 );

// action *after* mail send
add_action( 'wpforms_process_complete', function( $fields, $entry, $form_data, $entry_id ) {
    if (strpos(@$form_data['settings']['form_title'], 'Newsletter') === false) {
        return;
    }     
    $entry = wpforms()->entry->get( $entry_id );
    $entry_fields = json_decode( $entry->fields, true );
    // do custom logic
    //print_r($entry_fields);
}, 10, 4 );