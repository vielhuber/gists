<?php
header('Location: http://www.google.de');
header('Location: http://www.google.de', true, 301); // Moved permanently
header('Location: http://www.google.de', true, 302); // Moved temporarily
header('Location: http://www.google.de', true, 307); // Temporary redirect: Always use this, if you want to redirect a POST request (so the next request must also be POST!)
die();
