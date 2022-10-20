<?php
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class Uuid extends Migration
{
    public function up()
    {
        $query = <<<'EOD'
            SELECT * FROM (
            /* ... */
        EOD;

        $queries = DB::select(DB::raw($query));
        $count = count($queries);
        $count_cur = 0;
        foreach ($queries as $queries__value) {
            DB::statement(current((array) $queries__value));
            echo round((++$count_cur * 100) / $count) . '%' . PHP_EOL;
        }
    }
}