document.addEventListener('DOMContentLoaded', () => {
  if (document.querySelector('form') !== null) {
    document.querySelectorAll('form').forEach(el => {
    	el.setAttribute('autocomplete', 'off');
    });
  }
});
// fix firefox bug (https://gist.github.com/vielhuber/4baf17fbf0e581ad351146323cfc36de)
window.addEventListener('beforeunload', () => {
  if (document.querySelector('form') !== null) {
    document.querySelectorAll('form').forEach(el => {
      el.removeAttribute('autocomplete');
    });
  }
});