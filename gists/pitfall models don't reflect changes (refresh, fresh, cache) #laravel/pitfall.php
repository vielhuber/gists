<?php
$model = Model::find(42);
echo 'old value: '.$model->col;
$new_value = md5(uniqid());
DB::table('models')->where('id', 4)->update(['col' => $new_value]);
echo 'new value (should be '.$new_value.'): '.$model->col; // still the old value