$(document).ready(function()
{
  if( $('.masked-link').length > 0 )
  {
    $('.masked-link').each(function()
    {
      var old_el = $(this),
          html = old_el.html(),
          props = {},
          new_el = document.createElement('a');
      $.each(['style','class','href'], function(props__key, props__value)
      {
        if( old_el.is('['+props__value+']') )
        {
          props[props__value] = old_el.attr(props__value);
        }
      });  
      if( old_el.is('[data-href]') )
      {
        props['href'] = window.atob(old_el.attr('data-href'));
      }
      new_el.innerHTML = html;
      old_el.replaceWith(new_el);
      $.each(props, function(props__key, props__value)
      {
        $(new_el).attr(props__key, props__value);
      });
    });
  }
});