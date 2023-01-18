jQuery('html, body').animate({ scrollTop: 100 }, 1000); // needs jquery

hlp.scrollTo( 100, 1000 ); // needs hlp

window.scrollTo({ behavior: 'smooth', left: 0, top: 100 }); // does not work in IE or when smooth scrolling is disabled in chrome