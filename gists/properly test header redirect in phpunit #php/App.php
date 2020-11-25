<?php
// src/App.php
namespace Example;

class App
{
    public function redirect($url)
    {
        header('Location: ' . $url, true, 302);
        die();
    }
}
