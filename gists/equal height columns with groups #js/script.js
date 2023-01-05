window.addEventListener('load',function(e) { equalHeight(); }, false);
window.addEventListener('resize', function() { equalHeight(); } );
function equalHeight()
{
  let heights = {};
  if( document.querySelectorAll('.equal-height').length > 2 )
  {
    [].forEach.call(document.querySelectorAll('.equal-height'), (el) =>
    {
      el.style.height = 'auto';
    });
    [].forEach.call(document.querySelectorAll('.equal-height'), (el) =>
    {
      let heights__key = null;
      if( el.hasAttribute('class') && el.getAttribute('class').indexOf('equal-height--') > -1 )
      {
        heights__key = el.getAttribute('class').substring( el.getAttribute('class').indexOf('equal-height--') ).split(' ')[0];
      }
      else
      {
        heights__key = 'equal-height--1';
        el.classList.add(heights__key);
      }
      if( !(heights__key in heights) )
      {
        heights[heights__key] = 0;
      }
      if( el.clientHeight > heights[heights__key] )
      {
        heights[heights__key] = el.clientHeight;
      }
    });
    Object.entries(heights).forEach(([heights__key, heights__value]) =>
    {
      [].forEach.call(document.querySelectorAll('.'+heights__key), (el) =>
      {
        el.style.height = heights__value+'px';
      });
    });
  }
}