/* this script automagically grabs all elements with the given selector and sets only elements with the same offset to their neighbours maximum height */
let selectors = ['.equal-height'];
window.addEventListener('load', function(e) {
    equalHeight();
});
window.addEventListener('resize', function() {
    equalHeight();
});
function equalHeight() {
    selectors.forEach(selectors__value => {
        let heights = {},
            manipulate = [];
        if (document.querySelectorAll(selectors__value).length > 2) {
            [].forEach.call(document.querySelectorAll(selectors__value), el => {
                el.style.height = 'auto';
            });
            [].forEach.call(document.querySelectorAll(selectors__value), el => {
                let heights__key = Math.round(
                    el.getBoundingClientRect().top +
                        window.pageYOffset -
                        document.documentElement.clientTop
                );
                if (!(heights__key in heights)) {
                    heights[heights__key] = 0;
                }
                if (el.clientHeight > heights[heights__key]) {
                    heights[heights__key] = el.clientHeight;
                }
            });
            Object.entries(heights).forEach(([heights__key, heights__value]) => {
                [].forEach.call(document.querySelectorAll(selectors__value), el => {
                    if (
                        heights__key ==
                        Math.round(
                            el.getBoundingClientRect().top +
                                window.pageYOffset -
                                document.documentElement.clientTop
                        )
                    ) {
                        manipulate.push({ el: el, height: heights__value });
                    }
                });
            });
            manipulate.forEach(manipulate__value => {
                manipulate__value.el.style.height = manipulate__value.height + 'px';
            });
        }
    });
}
