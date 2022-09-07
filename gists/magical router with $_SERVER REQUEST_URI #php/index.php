// simply put this at the beginning of the script
// then you see the results of /bar when accessing /foo(!)
// in combination with output buffering this can be a magical approach
if( $_SERVER['REQUEST_URI'] === '/foo/' )
{
    $_SERVER['REQUEST_URI'] = '/bar/';
}
