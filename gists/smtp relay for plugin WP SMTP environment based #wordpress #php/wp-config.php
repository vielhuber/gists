<?php
if( strpos($_SERVER['HTTP_HOST'], 'custom.tld') !== false )
{
    define( 'WPMS_ON', true );
    define( 'WPMS_MAIL_FROM', 'noreply@custom.tld' );
    define( 'WPMS_MAIL_FROM_FORCE', true );
    define( 'WPMS_MAIL_FROM_NAME', 'Blah' );
    define( 'WPMS_MAIL_FROM_NAME_FORCE', true );
    define( 'WPMS_MAILER', 'smtp' );
    define( 'WPMS_SET_RETURN_PATH', false );
    define( 'WPMS_SMTP_HOST', 'mail.custom.tld' );
    define( 'WPMS_SMTP_PORT', 465 );
    define( 'WPMS_SSL', 'tls' );
    define( 'WPMS_SMTP_AUTH', false );
    define( 'WPMS_SMTP_USER', '' );
    define( 'WPMS_SMTP_PASS', '' );
}
else
{
    define( 'WPMS_ON', true );
    define( 'WPMS_MAIL_FROM', 'smtp@vielhuber.de' );
    define( 'WPMS_MAIL_FROM_FORCE', true );
    define( 'WPMS_MAIL_FROM_NAME', 'RED' );
    define( 'WPMS_MAIL_FROM_NAME_FORCE', true );
    define( 'WPMS_MAILER', 'smtp' );
    define( 'WPMS_SET_RETURN_PATH', false );
    define( 'WPMS_SMTP_HOST', 'sslout.df.eu' );
    define( 'WPMS_SMTP_PORT', 587 );
    define( 'WPMS_SSL', 'tls' );
    define( 'WPMS_SMTP_AUTH', true );
    define( 'WPMS_SMTP_USER', 'smtp@vielhuber.de' );
    define( 'WPMS_SMTP_PASS', '...' );
}