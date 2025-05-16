/* this ensures that ctrl+links open in a new window */
var ctrlPressed = false;
window.addEventListener('keydown', e => {
    if (e.metaKey || e.ctrlKey || e.key === 'Control' || e.key === 'Meta') {
        ctrlPressed = true;
    }
});
window.addEventListener('keyup', e => {
    if (e.metaKey || e.ctrlKey || e.key === 'Control' || e.key === 'Meta') {
        ctrlPressed = false;
    }
});

document.addEventListener('click', (e) => {
    if( ctrlPressed ) {
        return true;
    }
    /* do ajax / pushState etc. */
    /* ... */
    e.preventDefault();
});
