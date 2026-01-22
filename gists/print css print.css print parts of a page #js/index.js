if (document.querySelector('.print-page')) {
    window.onafterprint = function() {
        if (document.querySelector('.print-page-layout') !== null) {
            document.querySelector('.print-page-layout').remove();
        }
        if (document.querySelector('print-page-hide') !== null) {
            document.querySelectorAll('print-page-hide').forEach(el => {
                el.classList.remove('print-page-hide');
            });
        }
    };
    document.querySelectorAll('.print-page').forEach(el => {
        el.addEventListener('click', e => {
            if (el.getAttribute('data-print-layout') !== null) {
                document.head.insertAdjacentHTML(
                    'beforeend',
                    `
                    <style class="print-page-layout">
                        @media print {
                            @page {
                                size: A4 ${el.getAttribute('data-print-layout')};
                                margin: 1cm 1cm;
                            }
                            .print-page-hide {
                                display:none !important;
                            }
                        }  
                    </style>
                    `
                );
            }
            if (el.getAttribute('data-print-area') !== null) {
                document.querySelectorAll('*').forEach(el2 => {
                    if (
                        el2.closest(el.getAttribute('data-print-area')) !== null ||
                        el2.querySelector(el.getAttribute('data-print-area')) !== null
                    ) {
                        el2.classList.remove('print-page-hide');
                    } else {
                        el2.classList.add('print-page-hide');
                    }
                });
            }
            window.print();
            e.preventDefault();
        });
    });
}