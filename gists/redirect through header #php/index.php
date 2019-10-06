<?php
header('Location: http://www.google.de');
header('Location: http://www.google.de', true, 301); // Moved permanently
header('Location: http://www.google.de', true, 302); // Moved temporarily
die();
