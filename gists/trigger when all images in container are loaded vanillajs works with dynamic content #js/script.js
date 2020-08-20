document.addEventListener('DOMContentLoaded', () => {
    let selectorContainer = '.container',
        selectorImage = '.container__image';
    if (document.querySelector(selectorContainer) !== null) {
        window.addEventListener('load', e => {
            document.querySelector(selectorContainer).classList.add(selectorContainer.replace('.', '') + '--loaded');
            runAfterImagesLoaded();
            document.addEventListener(
                'load',
                event => {
                    let el = event.target;
                    if (
                        el.closest(selectorContainer) !== null &&
                        el.closest(selectorContainer + '--loaded') === null &&
                        el.classList.contains(selectorImage.replace('.', '')) &&
                        !el.classList.contains(selectorImage.replace('.', '') + '--loaded')
                    ) {
                        el.classList.add(selectorImage.replace('.', '') + '--loaded');
                        if (
                            el.closest(selectorContainer).querySelectorAll(selectorImage + '--loaded').length ===
                            el.closest(selectorContainer).querySelectorAll(selectorImage).length
                        ) {
                            el.closest(selectorContainer).classList.add(
                                selectorContainer.replace('.', '') + '--loaded'
                            );
                            runAfterImagesLoaded();
                        }
                    }
                },
                true
            );
        });
    }
});

function runAfterImagesLoaded() { console.log('DONE'); }
