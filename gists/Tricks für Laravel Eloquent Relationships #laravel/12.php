<?php
namespace App\Helpers;
use Illuminate\Database\Eloquent\Collection;
class ConvenienceCollection extends Collection
{
    public function __call($name, $args)
    {
        return new ConvenienceCollection($this->map(function($item,$key) use ($name,$args) {
            return $item->$name(...$args);
        })->flatten()->unique()->filter(function ($value, $key) { return __x($value); }));
    }
}
