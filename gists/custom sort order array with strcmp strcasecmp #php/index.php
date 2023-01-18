usort(['foo','bar','baz'], function($a, $b) {
  	return strcasecmp($a,$b);
});