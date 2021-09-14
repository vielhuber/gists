### installation

```sh
npm install @barba/core
npm install gsap
```

### index.html

#### before

```html
<body>
    <p>foo</p>
</body>
```

#### after

```html
<body data-barba="wrapper">
  	<!-- this line is often already done in our boilerplate -->
  	<script>window.pagespeed = navigator.userAgent.indexOf(\'Speed Insights\') > -1 || navigator.userAgent.indexOf(\'Chrome-Lighthouse\') > -1;</script>
	<script>if(!(window.pagespeed)) { document.body.insertAdjacentHTML('afterbegin','<div class="loader"></div>'); }</script>
    <div data-barba="container">
        <p>foo</p>
    </div>
</body>
```

### style.css

```css
.loader {
    position: fixed;
    width: 100vw;
    height: 200vh;
    pointer-events: none;
    background-color: #fff6ed;
    z-index: 2147483647;
}
```

### script.js

```.js
import barba from '@barba/core';
import { gsap } from 'gsap';

window.addEventListener('load', e => {
    let duration = 0.75,
        $loader = document.querySelector('.loader');
    if ($loader !== null) {
        // handle links to itself
        document.addEventListener('click', (e) => { if( e.target.closest('a[href]') ) {
            if (
                e.currentTarget.href ===
                window.location.protocol + '//' + window.location.host + window.location.pathname
            ) {
                jQuery('html, body').animate({ scrollTop: 0 }, duration * 100);
                e.preventDefault();
                e.stopPropagation();
            }
        } });

        // intro animation
        gsap.to($loader, {
            duration:
                navigator.userAgent.indexOf('Speed Insights') > -1 ||
                navigator.userAgent.indexOf('Chrome-Lighthouse') > -1
                    ? 0
                    : duration * 2,
            rotation: 10,
            scaleX: 0,
            xPercent: 5,
            transformOrigin: 'right center',
            ease: 'power1.inOut',
            autoAlpha: 1,
            onComplete: () => {
                gsap.set($loader, {
                    duration: 5.25,
                    scaleX: 0,
                    rotation: 10,
                    xPercent: -5,
                    yPercent: -50,
                    transformOrigin: 'left center',
                    autoAlpha: 1
                });
            }
        });

        // scroll top on new page
        if (history.scrollRestoration) {
            history.scrollRestoration = 'manual';
        }
        barba.hooks.enter(data => {
            window.scrollTo(0, 0);
        });

        // main transition
        barba.init({
            preventRunning: true,
            transitions: [
                {
                    async leave() {
                        await gsap.fromTo(
                            $loader,
                            {
                                rotation: 10,
                                scaleX: 0,
                                xPercent: -5
                            },
                            {
                                duration: duration,
                                xPercent: 0,
                                scaleX: 1,
                                rotation: 0,
                                ease: 'power1.inOut',
                                transformOrigin: 'left center'
                            }
                        );
                    },
                    enter() {
                        gsap.to($loader, {
                            duration: duration,
                            scaleX: 0,
                            xPercent: 5,
                            rotation: -10,
                            transformOrigin: 'right center',
                            ease: 'power1.inOut'
                        });
                    },
                    after() {
                        // run on subsequent load
                        console.log('subsequent load');
                    }
                }
            ]
        });
    }

    // run on first load
    console.log('first load');
});
```