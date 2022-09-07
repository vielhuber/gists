// without any response
header("Location: " . $_SERVER['REQUEST_URI']);
die();

// with a response using GET
header("Location: " . $_SERVER['REQUEST_URI'].'?response=foo');
die();