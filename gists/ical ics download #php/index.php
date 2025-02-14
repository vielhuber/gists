// composer require eluceo/ical
require_once(__DIR__ . '/vendor/autoload.php');

$date_begin = '2023-01-01 20:00:00';
$date_end = '2023-01-01 21:00:00';

$events = [];
$events[] = (new \Eluceo\iCal\Domain\Entity\Event())
        ->setCategory(['test1', 'test2'])
        ->setSummary('This is the title')
        ->setDescription('This is the description')
        ->setLocation(
          (new \Eluceo\iCal\Domain\ValueObject\Location('Neuschwansteinstraße 20, 87645 Schwangau', 'Schloss Neuschwanstein'))
              ->withGeographicPosition(new \Eluceo\iCal\Domain\ValueObject\GeographicPosition(47.557579, 10.749704))
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
        )
        ->setOccurrence(
            new \Eluceo\iCal\Domain\ValueObject\SingleDay(
                new \Eluceo\iCal\Domain\ValueObject\Date(
                    \DateTimeImmutable::createFromFormat('Y-m-d', $date_begin)
                )
            )
        );

$timezone = new \DateTimeZone('Europe/Berlin');
$calendar = new \Eluceo\iCal\Domain\Entity\Calendar($events);
$calendar->addTimeZone(
    \Eluceo\iCal\Domain\Entity\TimeZone::createFromPhpDateTimeZone(
        $timezone,
        new \DateTimeImmutable('2023-05-01 00:00:00', $timezone),
        new \DateTimeImmutable('2099-12-31 23:59:59', $timezone)
    )
);
header('Content-Type: text/calendar; charset=utf-8');
header('Content-Disposition: attachment; filename="cal.ics"');
echo (new \Eluceo\iCal\Presentation\Factory\CalendarFactory())->createCalendar($calendar);
die();