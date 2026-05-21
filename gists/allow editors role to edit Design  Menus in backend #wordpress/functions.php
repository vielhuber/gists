<?php
// add this ONCE, then open up the backend, then remove this again (because this modifies the database!)
$role_object = get_role( 'editor' );
$role_object->add_cap( 'edit_theme_options' );

// alternative: Capability Manager Enhanced
