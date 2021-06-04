<?php
/*
...
*/
public function sortByMulti($args)
{
    return $this->sort(__array_multisort($args));
}