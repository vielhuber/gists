<?php
/*
...
*/    
public function getFirst(callable $callback = null, $default = null)
{
    return __e($this->first($callback, $default));
}

public function getLast(callable $callback = null, $default = null)
{
    return __e($this->last($callback, $default));
}

public function getNth($i)
{
    return __e(@$this->offsetGet($i - 1));
}