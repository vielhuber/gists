$(window).resize(function() { adaptiveImages(); });
$(document).ready(function() { adaptiveImages(); });
function adaptiveImages() {
  $('.adaptive').each(function() {
  	if( $(this).hasClass(whatDevice()) ) { return; }
  	$(this).removeClass('desktop').removeClass('tablet').removeClass('mobile').addClass(whatDevice());
  	if( $(this).is('div') ) { $(this).css('background-image', "url('"+$(this).attr('data-background-image-'+whatDevice())+"')"); }
  	if( $(this).is('img') ) { $(this).attr('src', $(this).attr('data-src-'+whatDevice())); }
  });
}
// function to determine device (only based on width)
function whatDevice() {
  if( $(window).width() > 1280 ) { return 'desktop'; }
  else if( $(window).width() > 760 ) { return 'tablet'; }
  else { return 'mobile'; }
}