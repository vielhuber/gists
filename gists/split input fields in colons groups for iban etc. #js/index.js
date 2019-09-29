// be aware: the form is posted WITH the whitespace and has to be stripped after post
document.addEventListener('DOMContentLoaded', () => {
    function splitInputFieldIntoGroups(el, num) {
        let val = el.value.split(' ').join('');
        if (val.length > 0) {
            val = val.match(new RegExp('.{1,'+num+'}', 'g')).join(' ');
        }
        el.value = val;
    }
    if( document.querySelector('[data-group]') !== null )
    {
        document.querySelectorAll('[data-group]').forEach((el) => {
            console.log([el, el.getAttribute('data-group')]);
            splitInputFieldIntoGroups(el, el.getAttribute('data-group'));
            el.addEventListener('input', () => { splitInputFieldIntoGroups(el, el.getAttribute('data-group')); });
        });
    }
});
