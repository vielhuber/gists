$(document).ready(function() {
	var curPos = $(window).scrollTop();
	var lastPos = curPos;
	$(window).scroll(function() {
	  // if is not mobile (other checks possible)
		if( $(window).width() > 900 ) { $('#header').show(); return; }
		curPos = $(window).scrollTop();
		if( curPos < lastPos && !$('#header').is(':visible') && curPos <= ($(document).height()-$(window).height()-$('#header').height()) ) {
			$('#header').slideDown();
		}
		else if( curPos > 0 && curPos > lastPos && $('#header').is(':visible') ) {
			$('#header').slideUp();
		}
		// throttle
		if( Math.abs(curPos-lastPos) > 50 ) {
			lastPos = curPos;
		}
	});
});