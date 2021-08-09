document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('[data-clip]') !== null ) {
        document.querySelectorAll('[data-clip]').forEach(el => {
            fetch(el.getAttribute('data-clip')).then(v=>v.text()).catch(v=>v).then(html => {
                let svg = new DOMParser().parseFromString(html, 'text/html').body.childNodes[0],
                    clipPath = svg.querySelector('clipPath');
                if( clipPath !== null && svg.getAttribute('viewBox') !== null && clipPath.getAttribute('id') !== null ) {
                    clipPath.setAttribute('clipPathUnits','objectBoundingBox');
                    let viewBox = svg.getAttribute('viewBox'),
                        w = parseFloat(viewBox.split(' ')[2]),
                        h = parseFloat(viewBox.split(' ')[3]),
                        transform = 'scale('+(1/w)+', '+(1/h)+')' + (clipPath.getAttribute('transform') !== null ? ' ' + clipPath.getAttribute('transform') : '');
                    svg.style.width = '0';
                    svg.style.height = '0';
                    clipPath.setAttribute('transform', transform);
                    document.body.appendChild(svg);
                    el.style.clipPath = 'url("#'+clipPath.getAttribute('id')+'")';
                }
            });
        });
    }
});