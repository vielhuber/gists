/* jquery */
$(document).ready(function()
{
	$('body').on('contextmenu', 'img', function(e)
	{
  		return false;
	});
});

/* vanillajs */
window.oncontextmenu = function(e) { return false; }