<?php
/*
...
*/
public function sortByDefault()
{
    if (__x($this->getFirst())) {
        return $this->sort(
            __array_multisort(function ($v) {
                return $this->getFirst()->sortByDefault($v);
            })
        );
    }
    return $this;
}