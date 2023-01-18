$(document).ready(function() {
	$('iframe').each(function() {
		var self = this;
		$(self).load(function() { updateIframe(self); });				
	});
});
$(window).resize(function() {
	$('iframe').each(function() {
		updateIframe(this);
	});
});
function updateIframe(self) {
	$(self).height( $(self).get(0).contentWindow.document.body.scrollHeight );
}