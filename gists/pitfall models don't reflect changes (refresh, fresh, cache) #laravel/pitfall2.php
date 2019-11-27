<?php
$model = Model::find(42);
$dependant_table = $model->dependant_table; // gets all table entries for the first time and store it there for further usage
echo 'old value: '.$dependant_table->first()->another_col;
$new_value = md5(uniqid());
DB::table('dependant_table')->where('model_id', 42)->update(['another_col' => $new_value]);
$dependant_table = $model->dependant_table;
echo 'new value (should be '.$new_value.'): '.$dependant_table->first()->another_col; // this is still the old value(!)