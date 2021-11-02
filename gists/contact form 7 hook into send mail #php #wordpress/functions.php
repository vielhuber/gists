<?php
add_action('wpcf7_before_send_mail', function($cf7)
{
    $wpcf = \WPCF7_ContactForm::get_current();
    if( strpos($wpcf->title(),'Newsletter') === false )
    {
      return $wpcf;
    }
    $email = null;
    $first_name = null;
    $last_name = null;
    $submission = \WPCF7_Submission::get_instance();
    if($submission)
    {
      $posted = $submission->get_posted_data();
      foreach($posted as $posted__key=>$posted__value)
      {
          if( $posted__key == 'email' ) { $email = $posted__value; }
          if( $posted__key == 'first_name' ) { $first_name = $posted__value; }
          if( $posted__key == 'last_name' ) { $last_name = $posted__value; }
      }
    }
    if( $email === null || $first_name === null || $last_name === null ) { return $wpcf; }
  
  	// do whatever you want to do with that data (store in sql, push to mailchimp api, ...)
  	// ...
  
    $wpcf->skip_mail = true;
    return $wpcf;
});