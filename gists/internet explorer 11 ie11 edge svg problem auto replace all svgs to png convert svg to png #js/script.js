// variant 1 (does not work on pseudo elements and does not check if file exists)
document.addEventListener('DOMContentLoaded', () =>
{  
        if( navigator.userAgent.indexOf('MSIE') !== -1 || navigator.appVersion.indexOf('Trident/') > 0)
        {
            [].forEach.call(document.body.querySelectorAll('*'), (el) =>
            {
                if( el.tagName === 'IMG' && el.hasAttribute('src') && el.getAttribute('src').indexOf('.svg') > -1 )
                {
                    el.setAttribute('src', el.getAttribute('src').replace('.svg','.svg.png'));
                }
                else if( window.getComputedStyle(el).backgroundImage != '' && window.getComputedStyle(el).backgroundImage.indexOf('.svg') > -1 )
                {
                    let prop = window.getComputedStyle(el).backgroundImage;
                    if( prop.indexOf('.svg")') > -1 ) { prop = prop.replace('.svg")','.svg.png")'); }
                    if( prop.indexOf('.svg\')') > -1 ) { prop = prop.replace('.svg\')','.svg.png\')'); }
                    if( prop.indexOf('.svg)') > -1 ) { prop = prop.replace('.svg)','.svg.png)'); }
                    el.style.backgroundImage = prop;
                }
            });
        }
});