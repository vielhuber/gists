// pass additional data
setTimeout(() => { document.querySelector('.foo').dispatchEvent(new CustomEvent('change', { 'bubbles': true, 'detail': {'foo':'bar'} })); }, 3000);
document.querySelector('.foo').addEventListener('change', e => { console.log(e.detail); });