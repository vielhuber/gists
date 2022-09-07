### based on media queries (currently not working in chrome, see https://stackoverflow.com/questions/25907930/chrome-not-respecting-video-source-inline-media-queries)

```html
<video>
    <source src="video-big.mp4" type="video/mp4" media="all and (min-width: 1024px)"> 
    <source src="video-medium.mp4" type="video/mp4" media="all and (min-width: 768px)"> 
    <source src="video-small.mp4" type="video/mp4" />
</video>
```

### js solution (working)

```html
<video autoplay controls muted>
    <source data-src="video-big.mp4" data-mw="1600" type="video/mp4">
    <source data-src="video-medium.mp4" data-mw="900" type="video/mp4">
    <source data-src="video-small.mp4" type="video/mp4">
</video>

<script>
document.addEventListener('DOMContentLoaded', () => {
    if( document.querySelector('video') !== null ) {
        document.querySelectorAll('video').forEach($el => {
            if( $el.querySelector('source[data-src]') !== null ) {
                let options = [];
                $el.querySelectorAll('source[data-src]').forEach($el2 => {
                    options.push({
                        src: $el2.getAttribute('data-src'),
                        mw: $el2.getAttribute('data-mw') ? $el2.getAttribute('data-mw') : 0,
                        type: $el2.getAttribute('type')
                    });
                });
                $el.options = options;
                videoUpdateSource($el, true);
                window.addEventListener('resize', () => { videoUpdateSource($el); });
            }
        });
    }
});
function videoUpdateSource($el) {
    if( $el !== null ) {
        let curSrc = null,
            newSrc = null;
        if( $el.curSrc !== undefined ) {
            curSrc = $el.curSrc;
        }
        $el.options.forEach(options__value => {
          	// we use screen.width (instead of window.innerWidth) here, because e.g. if you use a smaller window and go fullscreen, the physical screen size is deciding)
            if( newSrc === null && options__value.mw < screen.width ) {
                newSrc = options__value;
            }
        });
        if( curSrc === null || curSrc.mw != newSrc.mw ) {
            $el.pause();
            $el.innerHTML = '';
            $el.insertAdjacentHTML('beforeend','<source src="'+newSrc.src+'" type="'+newSrc.type+'" />');
            $el.load();
            $el.play();
            $el.curSrc = newSrc;
        }
    }
}
</script>
```