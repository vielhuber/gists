<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
class CustomCreateTable extends Migration
{
    public function up()
    {
        Schema::create('custom', function( Blueprint $table ) {
            $table->bigIncrements('id');
            $table->timestamps(); // leave this here if you want (created_at and updated_at are added)
        });
    }
    public function down()
    {
        Schema::dropIfExists('custom');
    }
}
