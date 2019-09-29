import ResizeObserver from 'resize-observer-polyfill';
const observer = new ResizeObserver((entries, observer) => {
    // size of dom object changed
});
observer.observe(document.querySelector('.foo'));
observer.observe(document.body);