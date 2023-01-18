// add this ONCE, then open up the backend, then remove this again (because this modifies the database!)
$role_object = get_role( 'editor' );
$role_object->add_cap( 'wpml_manage_string_translation' );

// alternative: Capability Manager Enhanced