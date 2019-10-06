<?php
// do some logic
// ...

// save message
show_message('Erfolgreich');

// prg
prg();

function show_message($content, $type = 'success')
{
    // fetch existing message(s)
    if( isset($_COOKIE['message']) )
    {
        $message = base64_decode($_COOKIE['message']);
    }
    else
    {
        $message = '';
    }

    // append new message
    $message .= '<div class="message '.$type.'">';
        $message .= $content;
    $message .= '</div>';

    // save
    setcookie('message', base64_encode($message), time()+60*60*24*1, '/');
    $_COOKIE['message'] = base64_encode($message);
}