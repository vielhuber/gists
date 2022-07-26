<?php
/* pdf preview black backgrounds bugfix (see https://core.trac.wordpress.org/ticket/45982) */
require_once ABSPATH . 'wp-includes/class-wp-image-editor.php';
require_once ABSPATH . 'wp-includes/class-wp-image-editor-imagick.php';
final class ExtendedWpImageEditorImagick extends WP_Image_Editor_Imagick {
    protected function pdf_load_source() {
        $loaded = parent::pdf_load_source();
        try {
            $this->image->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
            $this->image->setBackgroundColor('#ffffff');
        } catch (Exception $exception) {
            error_log($exception->getMessage());
        }
        return $loaded;
    }
}
add_filter('wp_image_editors', function (array $editors): array {
    array_unshift($editors, ExtendedWpImageEditorImagick::class);
    return $editors;
});