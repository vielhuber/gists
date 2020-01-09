<?php
/*
...
*/
public function sortByLabel()
{
    return $this->sortBy(function ($a) {
        return $a->getLabel();
    });
}