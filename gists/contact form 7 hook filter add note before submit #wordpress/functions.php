add_filter('wpcf7_form_elements', function($content)
{
    $note = '';
    $note .= '<span class="contact-form-note">';
        $note .= 'Mit dem Absenden des Formulars erklären Sie sich damit einverstanden, dass Ihre Daten zur Bearbeitung Ihres Anliegens verwendet werden (weitere Informationen und Widerrufshinweise finden Sie in der <a target="_blank" href="'.get_bloginfo('url').'/datenschutz">Datenschutzerklärung</a>).';
    $note .= '</span>';
    $content = str_replace('<input type="submit', $note.'<input type="submit', $content);
    return $content;
}, 10, 4 );