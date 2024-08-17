<?php
$collection = new \App\Helpers\ConvenienceCollection(['foo' => 'bar', 'bar' => 'baz']);
dd($collection->getFoo()); // bar