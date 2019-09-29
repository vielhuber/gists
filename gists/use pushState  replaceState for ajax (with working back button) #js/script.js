updateAjax('test.html');
function updateAjax(url) {
	history.pushState({ goBack: true }, '', url);
	loadPage(url);
}
// this has to be done, because e.g. on safari popstate gets fired on page load
history.replaceState({ goBack: true }, '');
$(window).on("popstate", function(e) {
	if( !e.originalEvent.state.goBack ) { return; }
	loadPage(window.location.href);
});
function loadPage(url) {
	// do the ajax call and inject
	alert('loading '+url);
}