import ResizeObserver from 'resize-observer-polyfill';
const observer = new ResizeObserver(entries => {
    // size of dom object changed
    entries.forEach(entries__value => {
      const cr = entries__value.contentRect;
      console.log('Element:', entries__value.target);
      console.log(`Element size: ${cr.width}px x ${cr.height}px`);
      console.log(`Element padding: ${cr.top}px ; ${cr.left}px`);
    });
});
observer.observe(document.querySelector('.foo'));
observer.observe(document.body);