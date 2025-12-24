var userAgent = navigator.userAgent || navigator.vendor || window.opera;
if (/windows phone/i.test(userAgent)) { $('html').addClass('windows'); }
else if (/android/i.test(userAgent)) { $('html').addClass('android'); }
else if (/iPad|iPhone|iPod/.test(userAgent) && !window.MSStream) { $('html').addClass('ios'); }