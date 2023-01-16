<?php
$output = Phone::whereIn('member_id',Member::where('name','foo');

$output->pluck('id') // collection
$output->pluck('id')->all() // array
$output->implode('id',',') // string