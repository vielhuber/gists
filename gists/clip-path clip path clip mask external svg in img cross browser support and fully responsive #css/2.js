document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('[data-clip]') !== null ) {
        document.querySelectorAll('[data-clip]').forEach(el => {
            fetch(el.getAttribute('data-clip')).then(v=>v.text()).catch(v=>v).then(html => {
                let svg = new DOMParser().parseFromString(html, 'text/html').body.childNodes[0];
                if( svg.querySelector('clipPath') !== null && svg.getAttribute('viewBox') !== null ) {
                    let randomId = 'cp_'+~~(Math.random()*(99999-10000+1))+10000,
                        curId = svg.querySelector('clipPath').getAttribute('id');
                    if( curId !== null ) {
                        html = html.split('url(#'+curId+')').join('url(#'+randomId+')');
                        html = html.split('url(#'+curId+')').join('url("#'+randomId+'")');
                        html = html.split('id="#'+curId+'"').join('id="#'+randomId+'"');
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
                  	el.style.webkitClipPath = 'url("#'+svg.querySelector('clipPath').getAttribute('id')+'")';
                    // fix nasty ios bug (if any grandparent has overflow:hidden, the clip pathed mask is overflowing)
                    if( /^((?!chrome|android).)*safari/i.test(navigator.userAgent) ) {
                      let wrapper = new DOMParser().parseFromString('<div style="display:inline-block;overflow:hidden;"></div>', 'text/html').body.childNodes[0];
                      el.parentNode.insertBefore(wrapper, el.nextSibling);
                      wrapper.appendChild(el);
                    }
                    el.style.opacity = '1';
                }
            });
        });
    }
});