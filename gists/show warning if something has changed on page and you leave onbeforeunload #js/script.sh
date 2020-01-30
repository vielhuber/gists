var somethingHasChanged = false;

window.addEventListener('load', e => {
  window.addEventListener('beforeunload', e => {
    if (somethingHasChanged === true) {
      e.preventDefault();
      e.returnValue = '';
    }
  });
  document.addEventListener(
  	'submit',
  	e => {
  		somethingHasChanged = false;
  	},
  	true
  );
  document.addEventListener(
    'change',
    e => {
    	somethingHasChanged = true;
    },
    true
  );
});