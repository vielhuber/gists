document.addEventListener('DOMContentLoaded', () =>
{
  if( document.querySelector('textarea.autoheight') !== null )
  {
    let minHeight = 55;
    document.querySelectorAll('textarea.autoheight').forEach((el) => {
      el.style.overflowY = 'hidden';
      el.style.resize = 'none';
      el.style.height = '5px';
      el.style.height = Math.max(el.scrollHeight,minHeight) + 'px';
      el.addEventListener('keyup', e => {
        el.style.height = '5px';
        el.style.height = Math.max(el.scrollHeight,minHeight) + 'px';
      });
    });
  }
});