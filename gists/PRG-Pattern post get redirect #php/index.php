// without any response
header("Location: " . $_SERVER['REQUEST_URI']);
die();

// with a response using GET
header("Location: " . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH).'?response=foo');
die();