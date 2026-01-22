function colorBlend(start, end, ratio) {
  if( start.indexOf('#') === 0 ) { start = start.substring(1); }
  if( end.indexOf('#') === 0 ) { end = end.substring(1); }
	var hex = function(x) { x = x.toString(16); return (x.length == 1) ? '0' + x : x; };
	var r = Math.ceil(parseInt(end.substring(0,2), 16) * ratio + parseInt(start.substring(0,2), 16) * (1-ratio));
	var g = Math.ceil(parseInt(end.substring(2,4), 16) * ratio + parseInt(start.substring(2,4), 16) * (1-ratio));
	var b = Math.ceil(parseInt(end.substring(4,6), 16) * ratio + parseInt(start.substring(4,6), 16) * (1-ratio));
	return hex(r) + hex(g) + hex(b);
}
alert( colorBlend('#FF0000','#008000',0.5) );