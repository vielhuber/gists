import aae from 'adobe-animate-embed';

let a1 = new aae(
    document.querySelector('.dom-elem'),
    '/data/animation1/animation1.js'
);

a1.start();