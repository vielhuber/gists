function getTextBetweenTags($string, $tagname)
{
    $return = [];
    $pattern = "/<$tagname ?.*>(.*)<\/$tagname>/";
    preg_match_all($pattern, $string, $matches);
    if( isset($matches[1]) )
    {
        foreach($matches[1] as $matches__value)
        {
            if( trim($matches__value) == '' ) { continue; }
            $return[] = $matches__value;
        }
    }
    return $return;
}
getTextBetweenTags('h2', '<div><h2>foo</h2><h3>bar</h3><h2>baz</h2></div>') // ['foo','baz']