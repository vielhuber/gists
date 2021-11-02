/* basic */
window.addEventListener('resize', debounce(() => { console.log('debounce at resize') }, 1000));

/* get key event */
document.querySelector('.container').addEventListener('input', hlp.debounce((e) => { console.log('debounce at '+e.target.value+'/'+e.currentTarget.value); }, 1000));

/* conditional debounce */
let debounce = debounce(e => { console.log(e); }, 1000); // create this first (important to prevent wrong behaviour)
document.querySelector('.container').addEventListener('input', e => { if (e.target && e.target.tagName === 'TEXTAREA') { debounce(e); } });

/* manually call debounce */
let fn = debounce(() => { console.log('debounce at resize') }, 1000);
fn();