<?php
public static function getItem($id)
{
    if (__nx($id)) {
        return __empty();
    }
    $model = self::find($id);
    if ($model === null) {
        return __empty();
    }
    return $model;
}