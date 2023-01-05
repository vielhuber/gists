<?php
$model = Model::find(42);
$dependant_table = $model->dependant_table(); // gets the relationship and does not store it
echo 'old value: '.$dependant_table->first()->another_col;
$new_value = md5(uniqid());
DB::table('dependant_table')->where('model_id', 42)->update(['another_col' => $new_value]);
$dependant_table = $model->dependant_table();
echo 'new value (should be '.$new_value.'): '.$dependant_table->first()->another_col; // this is the new value