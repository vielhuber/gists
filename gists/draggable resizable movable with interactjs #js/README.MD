```sh
npm install --save interactjs
```

```js
import interact from 'interactjs';

interact('.foo')
    .draggable({
        allowFrom: '.handle',
        listeners: [{
            start: event => {
                event.target.style.userSelect = 'none';
            },
            end: event => {
                event.target.style.userSelect = 'auto';
            },
            move: event => {
                let target = event.target,
                    x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
                    y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;
                target.style.transform = 'translate(' + x + 'px, ' + y + 'px)';
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }
        }]
    })
    .resizable({
        edges: { top: true, right: true, bottom: true, left: true },
        listeners: [{
            start: event => {
                event.target.style.userSelect = 'none';
            },
            end: event => {
                event.target.style.userSelect = 'auto';
            },
            move: event => {
                let target = event.target,
                    x = parseFloat(target.getAttribute('data-x')) || 0,
                    y = parseFloat(target.getAttribute('data-y')) || 0;
                target.style.width = event.rect.width + 'px';
                target.style.height = event.rect.height + 'px';
                x += event.deltaRect.left;
                y += event.deltaRect.top;
                target.style.transform = 'translate(' + x + 'px,' + y + 'px)';
                target.setAttribute('data-x', x);
                target.setAttribute('data-y', y);
            }
        }]
    });
```