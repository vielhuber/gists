document.addEventListener('DOMContentLoaded', () => {
  if( document.querySelector('table') !== null )
  {
    document.querySelectorAll('table').forEach((el) => {
        let wrap = new DOMParser().parseFromString('<div class="responsive-table-container"></div>', 'text/html').body.childNodes[0];
        el.parentNode.insertBefore(wrap, el.nextSibling);
        wrap.appendChild(el);      
    })
  }
});