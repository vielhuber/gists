// set
document.body.insertAdjacentHTML('beforeend','<div class="foo" data-foo="'+encodeURIComponent(JSON.stringify({ bar: 'baz', baz: 'gnarr' ))+'"></div>');
// get
console.log( JSON.parse(decodeURIComponent(document.querySelector('.foo').getAttribute('data-foo'))) )