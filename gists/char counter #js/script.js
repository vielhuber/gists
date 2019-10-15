document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('[data-char-counter]') !== null) {
    document.querySelectorAll('[data-char-counter]').forEach((el) => {
      el.insertAdjacentHTML('afterend','<span class="char-counter"></span>');
      updateCharCounter(el);
      el.addEventListener('keyup', () => {
        updateCharCounter(el);
      });
    });
  }
});
function updateCharCounter(el)
{
  let length = el.value.length;
  el.nextElementSibling.textContent = length+'/'+el.getAttribute('data-char-counter');
  if( length > 50 ) {
    el.nextElementSibling.classList.add('char-counter--highlight');
  }
  else {
    el.nextElementSibling.classList.remove('char-counter--highlight');
  }
}