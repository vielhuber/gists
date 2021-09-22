<?php
namespace App\Helpers;
use Illuminate\Database\Eloquent\Collection;
class ConvenienceCollection extends Collection
{
    public function __call($name, $args)
    {
        /* the convenience collection has two modes:
        - getFoo()
            - if it contains a named attribute called "foo", it returns its value
            - otherwise it applies getFoo() to all elements of the collection
        */
        if (strpos($name, 'get') === 0 && isset($this[snake_case(substr($name, 3))])) {
            return $this[snake_case(substr($name, 3))];
        }
        $collection = $this->map(function ($item, $key) use ($name, $args) {
            try {
                $value = $item->$name(...$args);
            } catch (\Throwable $e) {
                $value = null;
            }
            return $value;
        })
            ->flatten()
            ->unique()
            ->filter(function ($value, $key) {
                return __x($value) || $value === false;
            })
            ->values(); // set consecutive keys;
        /*
        here it get's tricky:
        the ConvenienceCollection is a Database\Eloquent\Collection (which extends Support\Collection)
        because we want db functions like find() to work,
        there is a point where we get only items in the collection which are no models anymore.
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
