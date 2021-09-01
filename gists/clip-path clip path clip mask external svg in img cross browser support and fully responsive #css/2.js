document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('[data-clip]') !== null ) {
        document.querySelectorAll('[data-clip]').forEach(el => {
            fetch(el.getAttribute('data-clip')).then(v=>v.text()).catch(v=>v).then(html => {
                let svg = new DOMParser().parseFromString(html, 'text/html').body.childNodes[0];
                if( svg.querySelector('clipPath') !== null && svg.getAttribute('viewBox') !== null ) {
                    let randomId = 'cp_'+~~(Math.random()*(99999-10000+1))+10000,
                        curId = svg.querySelector('clipPath').getAttribute('id');
                    if( curId !== null ) {
                        html = html.replaceAll('url(#'+curId+')','url(#'+randomId+')');
                        html = html.replaceAll('url(#'+curId+')','url("#'+randomId+'")');
                        html = html.replaceAll('id="#'+curId+'"','id="#'+randomId+'"');
                        svg = new DOMParser().parseFromString(html, 'text/html').body.childNodes[0];
                    }
                    svg.querySelector('clipPath').setAttribute('id', randomId);
                    svg.querySelector('clipPath').setAttribute('clipPathUnits','objectBoundingBox');
                    let viewBox = svg.getAttribute('viewBox'),
                        w = parseFloat(viewBox.split(' ')[2]),
                        h = parseFloat(viewBox.split(' ')[3]),
                        transform = 'scale('+(1/w)+', '+(1/h)+')' + (svg.querySelector('clipPath').getAttribute('transform') !== null ? ' ' + svg.querySelector('clipPath').getAttribute('transform') : '');
                    svg.style.width = '0';
                    svg.style.height = '0';
                    svg.querySelector('clipPath').setAttribute('transform', transform);
                    document.body.appendChild(svg);
                    el.style.clipPath = 'url("#'+svg.querySelector('clipPath').getAttribute('id')+'")';
                    el.style.opacity = '1';
                }
            });
        });
    }
});