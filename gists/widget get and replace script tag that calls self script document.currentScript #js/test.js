let script = document.currentScript;
/* in case the script is added dynamically, use fallback */
if (script.getAttribute('data-foo') === null) {
    script = document.querySelector('script[data-foo]');
}
if (script !== null) {
	script.outerHTML = 'replace with magic';
  	/* ... */
}