var debug = ["var1", "var2", "var3"];
window.setInterval(function() {
	$('#debug').remove();
	$('body').append('<div id="debug" style="position:fixed;top:0;left:0;"></div>');
	for(var item of debug) {
		$('#debug').append(item+": "+eval(item)+"<br/>");
	}
},1000);