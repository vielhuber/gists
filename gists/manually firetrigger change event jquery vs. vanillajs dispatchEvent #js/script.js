setTimeout(() => { document.querySelector('.foo').dispatchEvent(new Event('change', { 'bubbles': true })); }, 3000);
document.addEventListener('change', e => { if( e.target.closest('.foo') ) { console.log(e.target.closest('.foo')); } }); // works
document.querySelector('.foo').addEventListener('change', e => { console.log(e.target); }); // works
$(document).on('change', '.foo', e => { console.log(e.target); }); // works
$('.foo').change(e => { console.log(e.target); }); // works

setTimeout(() => { $('.foo').change(); }, 3000);
document.addEventListener('change', e => { if( e.target.closest('.foo') ) { console.log(e.target.closest('.foo')); } }); // does not work
document.querySelector('.foo').addEventListener('change', e => { console.log(e.target); }); // does not work
$(document).on('change', '.foo', e => { console.log(e.target); }); // works
$('.foo').change(e => { console.log(e.target); }); // works