let args = {
   url: 'https://tld.com',
   target: '_blank',
   specs: {
      width: Math.round(window.innerWidth/1.5),
      height: Math.round(window.innerHeight/1.5),
      left: Math.round((window.innerWidth-(window.innerWidth/1.5))/2),
      top: Math.round((window.innerHeight-(window.innerHeight/1.5))/1.4), // little bit shifted from top
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