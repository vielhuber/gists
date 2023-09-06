document.addEventListener('DOMContentLoaded', () => {
    window.setTimeout(() => {

        let name, $el;

        name = 'test-1';
        if( document.querySelector('.'+name) === null ) {
            $el = document.createElement('script');
            $el.classList.add(name);
            $el.src = 'https://tld.com/test.js';
            //script.innerHTML = `alert('OK')`;
            $el.onload = () => { console.log('loaded!'); };
            document.head.appendChild($el);
        }

        name = 'test-2';
        if( document.querySelector('.'+name) === null ) {
            let $el = document.createElement('link');    
            $el.classList.add(name);
            $el.rel = 'stylesheet';
            $el.href = 'https://tld.com/test.css';
            document.head.appendChild($el);
        }

    }, 1000);
});