// use this function before sending out any data content to your vue / react state to get the state as object keyed by id
function recursivelyConvertArraysToObjects($arr)
{
    if( !is_object($arr) && !is_array($arr) )
    {
        return $arr;
    }
    if( is_array($arr) )
    {
        $new = new \stdClass();
        foreach($arr as $arr__key=>$arr__value)
        {
            if( is_object($arr__value) && isset($arr__value->id) )
            {
              if( filter_var($arr__value->id, FILTER_VALIDATE_INT) !== false ) { $arr__value->id = intval($arr__value->id); }
              $new->{$arr__value->id} = $arr__value;
            }
            elseif( is_array($arr__value) && isset($arr__value['id']) )
            {
              if( filter_var($arr__value['id'], FILTER_VALIDATE_INT) !== false ) { $arr__value['id'] = intval($arr__value['id']); }
              $new->{$arr__value['id']} = $arr__value;
            }
            else
            {
                $new->{$arr__key} = $arr__value;
            }
        }
        $arr = $new;
    }
    foreach($arr as $arr__key => $arr__value)
    {
        if( is_object($arr) )
        {
            $arr->{$arr__key} = $this->recursivelyConvertArraysToObjects($arr__value);
        }
        elseif( is_array($arr) )
        {
            $arr[$arr__key] = $this->recursivelyConvertArraysToObjects($arr__value);
        }
    }
    return $arr;
}