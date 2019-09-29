$(document).ready(function()
                  {
  if( isMobile.phone || $('a[href^="tel"]').length === 0 )
  {
    return;
  }
  $('a[href^="tel"]').each(function()
                           {
    $(this).replaceWith('<span'+(($(this).is('[class]'))?(' class="'+$(this).attr('class')+'"'):(''))+'>'+$(this).html()+'</span>');
  });
});