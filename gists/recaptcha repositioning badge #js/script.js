function waitUntil(selector) {
    return new Promise((resolve, reject) => {
        let timeout = setInterval(() => {
            if (document.querySelector(selector) !== null) {
                window.clearInterval(timeout);
                resolve();
            }
        }, 30);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    document.head.insertAdjacentHTML(
        'beforeend',
        `
            <style>
            .grecaptcha-badge {
                display: none!important;
                visibility: hidden!important;
                opacity: 0!important;
            }  
            </style>
            `
    );
    let selector = '.target-container';
    if (document.querySelector(selector) !== null) {
        this.waitUntil('.grecaptcha-badge').then(() => {
            let badge = document.querySelector('.grecaptcha-badge'),
                badgeNew = badge.cloneNode(true);
            badgeNew.classList.remove('grecaptcha-badge');
            badgeNew.style.display = 'block';
            badgeNew.style.visibility = 'visible';
            badgeNew.style.opacity = 1;
            badgeNew.style.filter = 'grayscale(100%)';
            badgeNew.style.position = 'relative';
            badgeNew.style.right = 0;
            badgeNew.style.bottom = 0;
            document.querySelector(selector).appendChild(badgeNew);
        });
    }
});
