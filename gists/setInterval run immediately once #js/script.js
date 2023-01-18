// option 1
function fn() {
    console.log('foo');
}
fn();
setInterval(fn, 5000);

// option 2
setInterval(
    (function fn() {
        console.log('foo');

        return fn;
    })(),
    5000
);

// option 3
(function fn() {
    console.log('foo');

    setTimeout(me, 5000);
})();