use Illuminate\Support\Carbon;

// create
Carbon::now();
Carbon::yesterday();
Carbon::today();
Carbon::now();
Carbon::now('Europe/London');
Carbon::tomorrow();
Carbon::createFromDate($year, $month, $day, $tz);
Carbon::createMidnightDate($year, $month, $day, $tz);
Carbon::createFromTime($hour, $minute, $second, $tz);
Carbon::createFromTimeString("$hour:$minute:$second", $tz);
Carbon::create($year, $month, $day, $hour, $minute, $second, $tz);
Carbon::parse('last day of February 2021'); 
Carbon::parse(1614470400);
new Carbon();
new Carbon('first day of January 2024');

// set
$dt = Carbon::now();
$dt->year(2024);
$dt->year(2024)->month(1)->day(7)->hour(20)->minute(30)->second(40);
$dt->subYears(10)
$dt->addDays(3);
$dt->subDays(3);

// output
$dt->year
$dt->year();
$dt->toDateString();
$dt->toTimeString();
$dt->toDateTimeString();
$dt->toFormattedDateString();
$dt->toFormattedDayDateString();
$dt->toDayDateTimeString();
$dt->format('l jS \\of F Y h:i:s A');

// diff
$dt1 = Carbon::now();
$dt1->diffForHumans()
$dt2 = Carbon::now()->addHours(6);
$dt1->diffInHours($dt2);