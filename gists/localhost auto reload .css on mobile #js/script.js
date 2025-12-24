$(document).ready(function() {
	if( $(window).width() < 1200 && $('.localhost').length > 0 ) {
	  var path_1 = $('head link[href*="style.css"]').attr('href');
	  var path_2 = $('head link[href*="px2rem.css"]').attr('href');
		setInterval(function() {
			$('head link[href*="style.css"]').attr('href',path_1+'?rand='+(~~(Math.random()*999)+100));
			$('head link[href*="px2rem.css"]').attr('href',path_2+'?rand='+(~~(Math.random()*999)+100));
		}, 5000);
	}
});