/* disable email bug alerts */
add_filter( 'recovery_mode_email', function( $email, $url ) {
    $email['to'] = 'unknown@local';
    return $email;
}, 10, 2 );