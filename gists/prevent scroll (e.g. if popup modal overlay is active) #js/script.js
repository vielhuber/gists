function preventScroll() {
    document.documentElement.classList.add('noscroll');
    if (document.head.querySelector('.noscroll-style') === null) {
        document.head.insertAdjacentHTML('beforeend', '<style class="noscroll-style">html.noscroll, html.noscroll body { overflow-y: hidden; }</style>');
    }
}

releaseScroll() {
    if (document.head.querySelector('.noscroll-style') !== null) {
        document.head.querySelector('.noscroll-style').remove();
    }
    if (document.documentElement.classList.contains('noscroll')) {
        document.documentElement.classList.remove('noscroll');
    }
}