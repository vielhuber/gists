var args = {
   url: "https://vielhuber.de",
   target: "_blank",
   specs: {
      width: ($(window).width()/1.5),
      height: ($(window).height()/1.5),
      left: (($(window).width()-($(window).width()/1.5))/2),
      top: (($(window).height()-($(window).height()/1.5))/2),
      menubar: false,
      scrollbars: false,
      status: false,
      toolbar: false
   }
}

var specs = '';
for (var p in args.specs) {
  if (args.specs.hasOwnProperty(p)) {
    if( args.specs[p] === true ) { args.specs[p] = 1; }
    if( args.specs[p] === false ) { args.specs[p] = 0; }
    specs += p + '=' + args.specs[p] + ',';
  }
}
specs = specs.substring(0, specs.length-1);

window.open(args.url,args.target,specs);