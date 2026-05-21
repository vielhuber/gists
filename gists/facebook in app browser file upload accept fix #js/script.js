/* fix upload in facebook in app browsers */
document.addEventListener('DOMContentLoaded', () => {
    let ua = navigator.userAgent || navigator.vendor || window.opera;
    if (ua.indexOf('FBAN') > -1 || ua.indexOf('FBAV') > -1 || ua.indexOf('Instagram') > -1) {
        if (document.querySelector('input[accept]') !== null) {
            document.querySelectorAll('input[accept]').forEach(el => {
                el.removeAttribute('accept');
            });
        }
    }
});