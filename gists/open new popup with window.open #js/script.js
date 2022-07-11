let w = window.innerWidth/1.5,
    h = window.innerHeight/1.5;
if( w < 870 ) { w = 870; }
if( h < 800 ) { h = 800; }
let args = {
   url: 'https://tld.com',
   target: '_blank',
   specs: {
      width: Math.round(w),
      height: Math.round(h),
      left: Math.round((window.innerWidth-(w))/2),
      top: Math.round((window.innerHeight-(h))/1.4), // little bit shifted from top
      menubar: false,
      scrollbars: false,
      status: false,
      toolbar: false
   }
}
let specs_str = '';
Object.entries(args.specs).forEach(([args__key, args__value]) => {
    if( args__value === true ) { args__value = 1; }
    if( args__value === false ) { args__value = 0; }
    specs_str += args__key + '=' + args__value + ',';
});
specs_str = specs_str.substring(0, specs_str.length-1);

window.open(args.url, args.target, specs_str);