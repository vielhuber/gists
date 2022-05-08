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
let specs = '';
Object.entries(args).forEach(([args__key, args__value]) => {
    if( args__value === true ) { args__value = 1; }
    if( args__value === false ) { args__value = 0; }
    specs += args__key + '=' + args__value + ',';
});
specs = specs.substring(0, specs.length-1);

window.open(args.url, args.target, specs);