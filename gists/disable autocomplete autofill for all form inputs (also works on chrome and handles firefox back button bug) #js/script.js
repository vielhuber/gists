document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('form') !== null) {
        document.querySelectorAll('form').forEach((el) => {
            el.setAttribute('autocomplete', 'off');
        });
    }
    /* chrome magic */
    if (/Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor)) {
        if (document.querySelector('input[name]:not([type="password"]):not([autocomplete])') !== null) {
            document.querySelectorAll('input[name]:not([type="password"]):not([autocomplete])').forEach((el) => {
                el.setAttribute(
                    'autocomplete',
                    el.getAttribute('name').match(/name|address|email|number/) ? 'cc-number' : 'off'
                );
                if (el.getAttribute('placeholder') !== null) {
                    el.setAttribute(
                        'placeholder',
                        el.getAttribute('placeholder').slice(0, 1) +
                            '\u200B' +
                            el.getAttribute('placeholder').slice(1)
                    );
                }
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
                    e.target.closest('input[name]:not([type="password"]):not([autocomplete])') !== null
                ) {
                    let el = e.target.closest('input[name]:not([type="password"]):not([autocomplete])');
                    el.setAttribute(
                        'autocomplete',
                        el.getAttribute('name').match(/name|address|email|number/) ? 'cc-number' : 'off'
                    );
                    if (el.getAttribute('placeholder') !== null) {
                        el.getAttribute('placeholder').slice(0, 1) +
                            '\u200B' +
                            el.getAttribute('placeholder').slice(1);
                    }
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