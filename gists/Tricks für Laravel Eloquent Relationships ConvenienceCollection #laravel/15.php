<?php
/*
...
*/
public function sortByMany($args)
{
    return $this->sort(__array_multisort($args));
}