let overall_time = 10, // seconds
    frames = 10,
    global_max = 0;
[].forEach.call(document.querySelectorAll('.stats__counter'), function(el) {
    if( parseInt(el.getAttribute('data-max')) > global_max ) { global_max = parseInt(el.getAttribute('data-max')); }
});
let interval = window.setInterval(function() {
    [].forEach.call(document.querySelectorAll('.stats__counter'), function(el) {
        let cur = (Math.round(parseFloat(el.getAttribute('data-cur'))*100)/100),
            max = parseInt(el.getAttribute('data-max')),
            add = (Math.round(((max/overall_time)*(frames/1000))*100)/100);
        if( cur < max ) {
            cur += add;
            el.setAttribute('data-cur',cur);
            el.textContent = Math.round(cur);
        }
        if( cur > global_max ) {
            clearInterval(interval);
        }
    });
}, frames);