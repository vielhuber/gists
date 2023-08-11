<?php
get_class($obj) // App\Models\Foo
class_basename($obj) // Foo
(new ReflectionClass($obj))->getShortName() // Foo