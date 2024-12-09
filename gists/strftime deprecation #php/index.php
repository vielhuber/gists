setlocale(LC_TIME, 'de_DE.utf8');
__strftime('%A, %d. %B %Y', strtotime('2001-01-01')); // Montag, 01. Januar 2001

IntlDateFormatter::formatObject(new DateTime('2001-01-01', new DateTimeZone('Europe/Berlin')), 'eeee, dd. MMMM yyyy', 'de_DE'); // Montag, 01. Januar 2001