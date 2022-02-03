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
        if (e.target.classList.contains('exclude') || e.target.closest('.exclude') !== null) {
        	return;
        }
        if (window.location.host.indexOf('local') > -1) {
        	//return;
        }
    	somethingHasChanged = true;
    },
    true
  );
});