<?php
add_action('wpcf7_contact_form', function($form) {
    $props = $form->get_properties();
    $props['mail']['subject'] = 'Neuer Betreff';
    $props['mail']['body'] = 'Neuer Body';
    $form->set_properties($props);
},9999);