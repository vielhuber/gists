<?php
namespace App\Helpers;
use Illuminate\Database\Eloquent\Collection;
class ConvenienceCollection extends Collection
{
    public function __call($name, $args)
    {
        $collection = $this->map(function ($item, $key) use ($name, $args) {
            return $item->$name(...$args);
        })->flatten()->unique()->filter(function ($value, $key) {
            return __x($value) || $value === false;
        });
        /*
        here it get's tricky:
        the ConvenienceCollection is a Database\Eloquent\Collection (which extends Support\Collection)
        because we want db functions like find() to work,
        there is a point where we get only items in the collection which a no models anymore.
        we detect this and break out of the convenience zone.
        this makes things possible like: 
        Person::find(42)->getAddresses()->getPerson()->getAddresses()->getPerson()->getId()->contains(42)
        */
        if ($collection->count() === 0 || is_subclass_of($collection->first(), 'App\Model')) {
            $collection = new ConvenienceCollection($collection);
        } else {
            $collection = collect($collection);
        }
        return $collection;
    }
}
