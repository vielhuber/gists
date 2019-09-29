document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('form') !== null) {
    document.querySelectorAll('form').forEach(el => {
    	el.setAttribute('autocomplete', 'off');
    });
  }
});