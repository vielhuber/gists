document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('form') !== null) {
        document.querySelectorAll('form').forEach((el) => {
            el.setAttribute('autocomplete', 'off');
        });
    }
    /* chrome magic */
    if (/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) {
        if (document.querySelector('input:not([type="password"]):not([autocomplete])') !== null) {
            document.querySelectorAll('input:not([type="password"]):not([autocomplete])').forEach((el) => {
                el.setAttribute('autocomplete', '_' + (~~(Math.random() * (9999 - 1000 + 1)) + 1000));
            });
        }
    }
    /* if you also want to include password fields */
    /*
    if (document.querySelector('input[type="password"]') !== null) {
        document.querySelectorAll('input[type="password"]').forEach((el) => {
            el.setAttribute('autocomplete', 'off');
        });
    }
    */
    document.addEventListener(
        'focus',
        (e) => {
            if (typeof e.target.closest !== 'undefined' && e.target.closest('form')) {
                if (!e.target.closest('form').hasAttribute('autocomplete')) {
                    e.target.closest('form').setAttribute('autocomplete', 'off');
                }
            }
            /* chrome magic */
            if (/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) {
                if (
                    typeof e.target.closest !== 'undefined' &&
                    e.target.closest('input:not([type="password"]):not([autocomplete])') !== null
                ) {
                    e.target
                        .closest('input:not([type="password"]):not([autocomplete])')
                        .setAttribute('autocomplete', '_' + (~~(Math.random() * (9999 - 1000 + 1)) + 1000));
                }
            }
            /* if you also want to include password fields */
            /*
            if (typeof e.target.closest !== 'undefined' && e.target.closest('input[type="password"]')) {
                if (!e.target.closest('input[type="password"]').hasAttribute('autocomplete')) {
                    e.target.closest('input[type="password"]').setAttribute('autocomplete', 'off');
                }
            }
            */
        },
        true
    );
});
// fix firefox bug (https://gist.github.com/vielhuber/4baf17fbf0e581ad351146323cfc36de)
window.addEventListener('beforeunload', () => {
  if (document.querySelector('form') !== null) {
    document.querySelectorAll('form').forEach(el => {
      el.removeAttribute('autocomplete');
    });
  }
});