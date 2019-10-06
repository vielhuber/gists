<?php
// app/Helpers/JobHelper.php
namespace App\Helpers;

use App;

class JobHelper
{

    public static function queue($class, $args = null, $run = false)
    {
        $class = '\\App\\Jobs\\'.$class;
        
        $class::dispatch($args);

        // immediately run (in background) on localhost
        if( App::environment('local') && $run === true && (!isset($_ENV['QUEUE_DRIVER']) || $_ENV['QUEUE_DRIVER'] != 'sync') )
        {
            if( !stristr(PHP_OS, 'DAR') && stristr(PHP_OS, 'WIN') )
            {
                popen( 'start C:\php\php.exe -c "C:\php\php.ini" '.base_path().'/artisan queue:work --env=local --once', 'r' );
            }
            else
            {
                exec('php '.base_path().'/artisan queue:work --env=local --once > /dev/null 2>/dev/null &');
            }
        }
    }

}
