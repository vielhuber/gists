<?php
/* ... */
Schema::create('table1', function (Blueprint $table) {
    // before
    //$table->bigIncrements('id');
    // after
    $table->uuid('id')->primary();
    /* ... */
    // before
    //$table->bigInteger('table2_id');
    // after
    $table->uuid('table2_id');
    /* ... */
});
/* ... */