document.addEventListener('DOMContentLoaded', () => {
    new MutationObserver(mutations => {
        mutations.forEach(mutations__value => {
            console.log(mutations__value.target);
        });    
    }).observe(document.body, {
            attributes: true,
            childList: true,
            characterData: true,
            subtree: true,
            attributeOldValue: true,
            characterDataOldValue: true
    });
});