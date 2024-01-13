// composer require eluceo/ical
require_once(__DIR__ . '/vendor/autoload.php');

$date_begin = '2023-01-01 20:00:00';
$date_end = '2023-01-01 21:00:00';

$d = new \DateTime($date_end, new \DateTimeZone('Europe/Berlin'));
$d->setTimeZone(new \DateTimeZone('UTC'));
$date_begin = $d->format('Y-m-d H:i:s');

$d = new \DateTime($date_end, new \DateTimeZone('Europe/Berlin'));
$d->setTimeZone(new \DateTimeZone('UTC'));
$date_end = $d->format('Y-m-d H:i:s');

$event = (new \Eluceo\iCal\Domain\Entity\Event())
        ->setSummary('This is the title')
        ->setDescription('This is the description')
        ->setLocation(
            new \Eluceo\iCal\Domain\ValueObject\Location(
                'This is the location',
                'This is the location'
            )
        )
        ->setOccurrence(
            new \Eluceo\iCal\Domain\ValueObject\TimeSpan(
                new \Eluceo\iCal\Domain\ValueObject\DateTime(
                    \DateTimeImmutable::createFromFormat(
                        'Y-m-d H:i:s',
                        $date_begin
                    ),
                    true
                ),
                new \Eluceo\iCal\Domain\ValueObject\DateTime(
                    \DateTimeImmutable::createFromFormat(
                        'Y-m-d H:i:s',
                        $date_end
                    ),
                    true
                )
            )
        );

$calendar = new \Eluceo\iCal\Domain\Entity\Calendar([$event]);
$componentFactory = new \Eluceo\iCal\Presentation\Factory\CalendarFactory();
$calendarComponent = $componentFactory->createCalendar($calendar);
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="file.ics"');
}
echo $calendarComponent;
die();