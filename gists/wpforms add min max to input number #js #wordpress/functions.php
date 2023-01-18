// wpforms: add min/max to number elements: Add class "limit_0_10" to input element (see https://wpforms.com/developers/how-to-limit-range-allowed-in-numbers-field/)
add_action( 'wpforms_wp_footer_end', function() {
    ?>
    <script type="text/javascript">
        window.addEventListener('load', e => {
            if( document.querySelector('.wpforms-field[class*="limit_"]') !== null ) {
                document.querySelectorAll('.wpforms-field[class*="limit_"]').forEach($el => {
                    let attr = $el.getAttribute('class'),
                        limit = attr.split(' ').filter(attr__value => attr__value.indexOf('limit_') > -1)[0],
                        min = limit.split('_')[1],
                        max = limit.split('_')[2];
                    $el.querySelector('input').setAttribute('min', min);
                    $el.querySelector('input').setAttribute('max', max);
                });
            }
        }); 
    </script>
    <?php
}, 30 );