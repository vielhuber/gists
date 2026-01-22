document.addEventListener('DOMContentLoaded', () =>
{
    if( document.querySelector('.Twitter-Share') !== null )
    {
        document.querySelectorAll('.Twitter-Share').forEach((el) => {
            el.outerHTML =
                '<a href="https://twitter.com/intent/tweet?text=' +
                encodeURI(el.textContent + ' - ' + window.location.href) +
                '" target="_blank">' +
                el.innerHTML +
                '</a>';
        });
    }
});
