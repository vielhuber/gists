/* technique 1 */
let link = document.createElement('link');
link.setAttribute('rel', 'preload');
link.setAttribute('as', 'font');
link.setAttribute('href', 'fonts/barlow-v2-latin-100.woff2');
/* ... */
document.head.appendChild(link);

/* technique 2 */
let html = '';
html += '<div class="fonts-preloader" style="opacity:0;position:absolute;">';
	html += '<span style="font-family: Barlow, sans-serif;"></span>';
	/* ... */
html += '</div>';
document.body.insertAdjacentHTML('beforeend', html);