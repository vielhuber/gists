$('#id')
document.getElementById('id')


$('#input').val()
document.getElementById('input').value

$('#input').val('foo')
document.getElementById('input').value = 'foo';

$('#input').attr('foo')
document.getElementById('input').getAttribute('foo')

$('#input').attr('foo','bar')
document.getElementById('input').setAttribute('foo','bar')

$('#input').removeAttr('foo')
document.getElementById('input').removeAttribute('foo')

if( $('.selector').is('[name]') ) { }
if( document.querySelector('.selector').hasAttribute('name') ) { }


$('.selector')
document.querySelector(".selector") // gets the first item
document.querySelectorAll(".selector") // gets all items


$('.parent').find('.children')
document.querySelector('.selector').querySelectorAll('.children')




$('#el').click();
document.getElementById('el').click();


$('.selector').click(function() { });
document.querySelector('.selector').addEventListener('click', (e) =>
{
  alert(e.currentTarget.getAttribute('href'));
  e.preventDefault();
}, false);
document.querySelector('.selector').addEventListener('click', function(e)
{
  alert(this.getAttribute('href'));
  e.preventDefault();
}, false);
// alternative way (the line above produces sometimes popup blocker on chrome)
document.querySelector('.selector').onclick = function() {
  return false;
}
// use also arrow functions not to lose scope
document.querySelector('.selector').onclick = () => { } 
document.querySelector('.selector').addEventListener('click', e => { });



$('#el').one('click', () =>
{
  alert('ok');
});
// variant 1 (modern)
document.getElementById('el').addEventListener('click', () =>
{
  alert('ok');
}, { once: true });
// variant 2 (legacy)
function addEventListenerOnce(target, type, listener, addOptions, removeOptions)
{
    target.addEventListener(type, function fn(event)
    {
        target.removeEventListener(type, fn, removeOptions);
        listener.apply(this, arguments, addOptions);
    });
}
addEventListenerOnce(document.getElementById('el'), 'click', (event) =>
{
    alert('ok');
});



$('.selector').each(function() { });
[].forEach.call(document.querySelectorAll('.selector'), function(el) { }); // querySelectorAll does not return an array!
[].forEach.call(document.querySelectorAll('.selector'), (el) => { });
document.querySelectorAll('.selector').forEach((el) => { }); // this does not work in IE
for(let el of document.querySelectorAll('.selector')) {}; // this does not work in IE

$('head')
document.head
document.getElementsByTagName('head')[0]


$('#el').css('background-image');
document.getElementById('el').style.backgroundImage // this only gives inline styles
window.getComputedStyle(document.getElementById('el')).backgroundImage // this also gives css styles


$('#el').css('padding-bottom');
document.getElementById('el').style.paddingBottom // this only gives inline styles
window.getComputedStyle(document.getElementById('el')).getPropertyValue('padding-bottom') // this also gives css styles


$('#el').css('pointer-events','none');
document.getElementById('el').style.pointerEvents = 'none';


$('#el').show();
$('#el').hide();
document.getElementById('el').style.display = 'block';
document.getElementById('el').style.display = 'none';


$('#el').html(); $('#el').html('foo');
document.getElementById('el').innerHTML; document.getElementById('el').innerHTML = 'foo';

$('#el').text(); $('#el').text('foo');
document.getElementById('el').textContent; document.getElementById('el').textContent = 'foo';


$('#el').addClass('foo');
document.getElementById("el").classList.add('foo');

$('#el').addClass('foo bar');
document.getElementById("el").classList.classList.add('foo','bar');
document.getElementById("el").classList.add(...['foo', 'bar']);



$('#el').removeClass('foo');
document.getElementById("el").classList.remove("foo");

$('#el').hasClass('foo');
document.getElementById("el").classList.contains('foo');

$('#el').toggleClass('foo');
document.getElementById("el").classList.toggle('foo');



$('.your-iframe').contents().find('body').html()
document.querySelector('.your-iframe').contentWindow.document.body.innerHTML;



$('#el').parent()
document.getElementById("el").parentNode;


$('#el').next()
document.getElementById("el").nextElementSibling;

$('#el').prev()
document.getElementById("el").previousElementSibling;


$('#el').children()
document.getElementById("el").children
$('#el').children().first()
document.getElementById("el").children[0]
$('#el').children().length > 0
document.getElementById("el").children.length > 0
$('#el').children('.foo')
$('#el').querySelectorAll(':scope > .foo')

if( $('#el').length > 0 ) { }
if( document.getElementById("el") ) { }
if( document.querySelector('.el') !== null ) { }
if( document.querySelectorAll('.el').length > 0 ) { }


$(document)
document


$('body')
document.body


$('html')
document.documentElement


$(document).ready(function() { });
document.addEventListener('DOMContentLoaded', function() { });


$(window).load(function() { });
window.addEventListener('load', e => { })
// warning, you can only use this ONCE:
window.onload = function() { }


$('#el').before('<div class="foo">*</div>');
var foo = document.createElement('div');
foo.innerHTML = '*';
foo.className = 'foo';
var el = document.getElementById('el');
el.parentNode.insertBefore(foo, el);






$('#el').remove();
// older
var el = document.getElementById('el'); el.parentNode.removeChild(el);
// newer (warning: babel does not transpile this)
document.getElementById('el').remove();



$(':input')
document.querySelectorAll('input, textarea, select, button')

$(':focus')
document.activeElement



$('#el').prepend('<span class="foo"></span>');
// variant 1
var parent = document.getElementById('el'); 
var child = document.createElement('span'); child.setAttribute('class','foo');
parent.insertBefore(child, parent.firstChild);
// variant 2
document.getElementById('el').insertAdjacentHTML('afterbegin','<span class="foo"></span>');
// variant 3
var parent = document.getElementById('el'); 
var child = new DOMParser().parseFromString('<span class="foo"></span>', 'text/html').body.childNodes[0];
parent.insertBefore(child, parent.firstChild);

$('#el').append('<span class="foo"></span>');
// variant 1
var parent = document.getElementById('el'); 
var child = document.createElement('span'); child.setAttribute('class','foo');
parent.appendChild(child);
// variant 2
document.getElementById('el').insertAdjacentHTML('beforeend','<span class="foo"></span>');
// variant 3
var parent = document.getElementById('el'); 
var child = new DOMParser().parseFromString('<span class="foo"></span>', 'text/html').body.childNodes[0];
parent.appendChild(child);


$('#el').before('<span class="foo"></span>');
document.getElementById('el').insertAdjacentHTML('beforebegin','<span class="foo"></span>');

$('#el').after('<span class="foo"></span>');
document.getElementById('el').insertAdjacentHTML('afterend','<span class="foo"></span>');


	
$('#el').wrap('<div class="wrapper"></div>');
let el = document.getElementById('el');
    wrapper = new DOMParser().parseFromString('<div class="wrapper"></div>', 'text/html').body.childNodes[0];
el.parentNode.insertBefore(wrapper, el.nextSibling);
wrapper.appendChild(el);




$('#el').after('<span></span>');
let el = document.querySelector('#el'),
    span = document.createElement('span');
// variant 1
el.after(span);
// variant 2
el.parentNode.insertBefore(span, el.nextSibling);


$('#el').before('<span></span>');
let el = document.querySelector('#el'),
    span = document.createElement('span');
// variant 1
el.before(span);
// variant 2
el.parentNode.insertBefore(span, el);





$.get('https://tld.com/api', function(data)
{
  console.log(data);
});

var xhr = new XMLHttpRequest();
xhr.onreadystatechange = function()
{ 
  if (this.readyState != 4 || this.status != 200) return;
  console.log(JSON.parse(this.responseText));
}
xhr.open( 'GET', 'https://tld.com/api', true );            
xhr.send( null );


$.ajax({
  method: "POST",
  url: "script.php",
  data: { name: "John", location: "Boston" }
}).done(function( data ) { });

var xhr = new XMLHttpRequest()
xhr.open('POST', "script.php", true);
xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest");
xhr.onreadystatechange = function()
{
  if (this.readyState != 4 || this.status != 200) return;
  console.log(JSON.parse(this.responseText));
}
xhr.send("name=John&location=Boston");


html
document.documentElement
body
document.body



$(window).scrollTop();
(document.documentElement && document.documentElement.scrollTop) || document.body.scrollTop;
window.pageYOffset || document.documentElement.scrollTop;

$(window).scrollTop(1000);
document.documentElement.scrollTop = document.body.scrollTop = 1000;

$('div').scrollTop();
document.querySelector('div').scrollTop


$(window).scroll(function() { });
window.onscroll = function() { function() { } };
window.addEventListener("scroll", function() { } );


$(window).resize(function() { });
window.onresize = function() { function() { } };
window.addEventListener("resize", function() { } );


$(window).width(); $(window).height();
window.innerWidth; window.innerHeight;
window.screen.availWidth; window.screen.availHeight; // sometimes in chrome dev tools you have to use this instead

$(document).height();
Math.max(document.body.offsetHeight, document.body.scrollHeight, document.documentElement.clientHeight, document.documentElement.offsetHeight, document.documentElement.scrollHeight);

$('#el').width(500);
document.getElementById("el").style.width = '500px';

$('#el').height(500);
document.getElementById("el").style.height = '500px';

$('#el').width()
parseInt(window.getComputedStyle(document.querySelector('#el')).width)
$('#el').innerWidth()
box.clientWidth
$('#el').outerWidth()
box.offsetWidth;
$('#el').outerWidth(true)
document.querySelector('#el').offsetWidth + parseInt(getComputedStyle(document.querySelector('#el')).marginLeft) + parseInt(getComputedStyle(document.querySelector('#el')).marginRight);

$('#el').height()
parseInt(window.getComputedStyle(document.querySelector('#el')).height)
$('#el').innerHeight()
box.clientHeight
$('#el').outerHeight()
box.offsetHeight
$('#el').outerHeight(true)
document.querySelector('#el').offsetHeight + parseInt(getComputedStyle(document.querySelector('#el')).marginTop) + parseInt(getComputedStyle(document.querySelector('#el')).marginBottom);


$('#el').offset().top;
(document.getElementById('el').getBoundingClientRect().top + window.pageYOffset - document.documentElement.clientTop)

$('#el').offset().left;
(document.getElementById('el').getBoundingClientRect().left + window.pageXOffset - document.documentElement.clientLeft)


$('#el').position().top
document.getElementById('el').offsetTop
$('#el').position().left;
document.getElementById('el').offsetLeft

 
 
$('#el').prevAll();
$('#el').prevAll('.foo');
prevAll(elem, filter) {
	let sibs = [];
	while ((elem = elem.previousElementSibling)) {
	    if (filter === undefined || elem.matches(filter)) {
		sibs.push(elem);
	    }
	}
	return sibs;
}
prevAll(document.querySelector('#el'));
prevAll(document.querySelector('#el'),'.foo');
$('#el').nextAll();
$('#el').nextAll('.foo');
nextAll(elem, filter)
{
        let sibs = [];
        while ((elem = elem.nextElementSibling)) {
            if (filter === undefined || elem.matches(filter)) {
                sibs.push(elem);
            }
        }
        return sibs;
}
nextAll(document.querySelector('#el'));
nextAll(document.querySelector('#el'),'.foo');







$('#el').siblings().each(function() { });
[...document.getElementById('el').parentNode.children].filter((child) => child !== document.getElementById('el')).forEach((i) => { });


$('form').submit(function() { });
document.querySelector('form').addEventListener('submit', function(e) {
  e.preventDefault();
}, false);


$('form').submit()
document.querySelector('form').submit()
HTMLFormElement.prototype.submit.call(document.querySelector('form'))



$('#el').closest('.foo');
document.getElementById('el').closest('.foo')



if( $('#el').is('textarea') ) { }
if( document.getElementById('el').tagName === 'TEXTAREA' ) { }


if( $('.selector').attr('id','foo') ) { }
if( document.querySelector('.selector').id === 'foo' ) { }




if( $('.selector').is(':visible') ) { }
if( !!( document.querySelector('.selector').offsetWidth || document.querySelector('.selector').offsetHeight || document.querySelector('.selector').getClientRects().length ) ) { }



$(document).on('click', 'a[href*="test.de"]', () => { });
$('#el').on('click', '.selector', (el) => { });
document.addEventListener('click', (e) => { if( e.target.closest('a[href*="test.de"]') ) { } });
document.querySelector('#el').addEventListener('click', (e) => { if( e.target.closest('.selector') ) { } });

$('#el').on('blur', 'input.selector', (el) => { });
document.querySelector('#el').addEventListener('blur', (e) => { if( e.target.closest('.selector') ) { } }, true);



$('<p>foo</p>').find('p')
// variant 1
new DOMParser().parseFromString('<p>foo</p>', 'text/html').querySelectorAll('p');
// variant 2
let tmp = document.createElement('div');
tmp.innerHTML = '<p>foo</p>';
tmp.querySelectorAll('p')
// variant 3
let html = '<p>foo</p>';
let template = document.createElement('template');
html = html.trim();
template.innerHTML = html;
let dom = template.content.firstChild;
dom.querySelectorAll('p');





$('.selector').prop('disabled', false);
$('.selector').prop('disabled', true);
document.querySelector('.selector').disabled = true;
document.querySelector('.selector').disabled = false;


// trigger manual change
$('input').change();
document.querySelector('input').dispatchEvent(new Event('change', { 'bubbles': true }));



$('form').serialize()
new URLSearchParams(new FormData(document.querySelector('form'))).toString()

