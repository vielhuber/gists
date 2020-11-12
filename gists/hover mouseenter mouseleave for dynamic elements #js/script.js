document.documentElement.addEventListener(
    'mouseenter',
    e => {
        if (e.target.closest('.foo')) {
            console.log('IN');
        }
    },
    true
);
document.documentElement.addEventListener(
    'mouseleave',
    e => {
        if (e.target.closest('.foo')) {
            console.log('OUT');
        }
    },
    true
);