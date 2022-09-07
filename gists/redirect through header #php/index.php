<?php
// Default redirect
// PHP uses by default a 302 header
header('Location: http://www.google.de');

// Moved permanently
// This should be used in most cases
header('Location: http://www.google.de', true, 301);

// Moved temporarily
// Always use this, if you do a browser-language-based redirect (e.g. from https://tld.com to https://tld.com/en/) or a temporary redirect (like for a campaign page that needs to be on a main url)
header('Location: http://www.google.de', true, 302);

 // Temporary redirect
// Always use this, if you want to redirect a POST request (so the next request must also be POST!)
header('Location: http://www.google.de', true, 307);

die();
