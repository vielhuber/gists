<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsUpdatedCreated extends Migration
{
    public function up()
    {
        foreach (self::getAllTables() as $tables__value) {
            Schema::table($tables__value, function (Blueprint $table) use ($tables__value) {
                if (!Schema::hasColumn($tables__value, 'created_by')) {
                    $table->integer('created_by')->nullable();
                }
                if (!Schema::hasColumn($tables__value, 'updated_by')) {
                    $table->integer('updated_by')->nullable();
                }
                if (!Schema::hasColumn($tables__value, 'created_at')) {
                    $table->timestamp('created_at')->nullable();
                }
                if (!Schema::hasColumn($tables__value, 'updated_at')) {
                    $table->timestamp('updated_at')->nullable();
                }
            });
        }
    }

    public function down()
    {
        foreach (self::getAllTables() as $tables__value) {
            Schema::table($tables__value, function (Blueprint $table) use ($tables__value) {
                if (Schema::hasColumn($tables__value, 'created_by')) {
                    $table->dropColumn('created_by');
                }
                if (Schema::hasColumn($tables__value, 'updated_by')) {
                    $table->dropColumn('updated_by');
                }
                if (Schema::hasColumn($tables__value, 'created_at')) {
                    $table->dropColumn('created_at');
                }
                if (Schema::hasColumn($tables__value, 'updated_at')) {
                    $table->dropColumn('updated_at');
                }
            });
        }
    }

    private function getAllTables()
    {
        $tables = [];
        foreach (
            DB::select(
                'SELECT table_name FROM information_schema.tables WHERE table_catalog = ? AND table_type = ? AND table_schema = ? ORDER BY table_name',
                [env('DB_DATABASE'), 'BASE TABLE', 'public']
            )
            as $tables__value
        ) {
            $tables[] = $tables__value->table_name;
        }
        return $tables;
    }
}
