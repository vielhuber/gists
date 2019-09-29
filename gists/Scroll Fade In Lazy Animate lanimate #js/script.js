function initLanimate()
{
  if( document.querySelectorAll('[data-lanimate]').length > 0 )
  {
    [].forEach.call(document.querySelectorAll('[data-lanimate]'), (el) =>
                    {
      startLanimate(el);
      window.addEventListener('scroll', () => { this.startLanimate(el); });
    });
  }
}

function startLanimate(el)
{
  if( !el.hasAttribute('data-lanimate-finished') && (hlp.scrollTop()+window.innerHeight) >= hlp.offsetTop(el) )
  {
    let delay = 0;
    if( el.hasAttribute('data-lanimate-delay') )
    {
      delay = el.getAttribute('data-lanimate-delay');
    }
    setTimeout(() =>
               {
      el.setAttribute('data-lanimate-finished','true');
    }, delay);
  }
}

initLanimate();