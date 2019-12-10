document.addEventListener('DOMContentLoaded', () => {
  if( document.querySelector('select[readonly]') !== null ) {
    document.querySelectorAll('select[readonly]').forEach((el) => {
      el.insertAdjacentHTML('afterend','<input type="hidden" name="'+el.getAttribute('name')+'" value="'+el.value+'" />');
      el.setAttribute('disabled','disabled');
    });
  }
});