document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('submit', e => {
        if (e.target.closest('form')) {
            let $form = e.target.closest('form'),
                $els = null;

            // single checkbox
            $els = $form.querySelectorAll(
                'input[type="checkbox"]:not(:checked)[name]:not([name$=\'[]\']):not([disabled])'
            );
            if ($els.length > 0) {
                $els.forEach($el => {
                    if (
                        $el.previousElementSibling === null ||
                        $el.previousElementSibling.getAttribute('type') !== 'hidden' ||
                        $el.previousElementSibling.value != '0'
                    ) {
                        $el.insertAdjacentHTML(
                            'beforebegin',
                            '<input type="hidden" value="0" name="' + $el.getAttribute('name') + '" />'
                        );
                    }
                });
            }

            // multiple checkbox
            $els = $form.querySelectorAll('input[type="checkbox"][name$=\'[]\']:not([disabled])');
            if ($els.length > 0) {
                $els.forEach($el => {
                    if (
                        document.querySelector(
                            'input[type="checkbox"][name="' + $el.getAttribute('name') + '"]:checked'
                        ) === null &&
                        document.querySelector(
                            'input[type="hidden"][name="' + $el.getAttribute('name') + '"]'
                        ) === null
                    ) {
                        $el.insertAdjacentHTML(
                            'beforebegin',
                            '<input type="hidden" value="0" name="' + $el.getAttribute('name') + '" />'
                        );
                    }
                });
            }

            // multiple select
            $els = $form.querySelectorAll('select[name$=\'[]\']:not([disabled])');
            if ($els.length > 0) {
                $els.forEach($el => {
                    if (
                        ($el.value === null || $el.value === '' || (Array.isArray($el.value) && $el.value.length === 0))
                        &&
                        document.querySelector(
                            'input[type="hidden"][name="' + $el.getAttribute('name') + '"]'
                        ) === null
                    ) {
                        $el.insertAdjacentHTML(
                            'beforebegin',
                            '<input type="hidden" value="" name="' + $el.getAttribute('name') + '" />'
                        );
                    }
                });
            }
        }
    });
});