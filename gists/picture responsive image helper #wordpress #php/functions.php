function getCommonScreenResolutions()
{
    return [360, 375, 414, 768, 1024, 1280, 1366, 1440, 1536, 1600, 1680, 1920, 2048, 2560, 4096];
}
function getMediaBreakpoints()
{
    return [768, 1024];
}
add_action('after_setup_theme', function () {
    foreach (getCommonScreenResolutions() as $resolutions__value) {
        add_image_size($resolutions__value . 'x', $resolutions__value, 0, false);
    }
});
function renderImage($image, $class = null, $ratio_large = 1, $ratio_medium = 1, $ratio_small = 1, $lazy = true)
{
    echo '<picture>';
        for (
            $i = floor(getCommonScreenResolutions()[0] / 100) * 100;
            $i <= ceil(array_reverse(getCommonScreenResolutions())[0] / 100) * 100;
            $i = $i + 100
        ) {
            $size = null;
            if ($i >= getMediaBreakpoints()[1]) { $ratio = $ratio_large; }
            elseif ($i >= getMediaBreakpoints()[0]) { $ratio = $ratio_medium; }
            else { $ratio = $ratio_small; }
            foreach (array_reverse(getCommonScreenResolutions()) as $resolutions__value) {
                if ($resolutions__value >= $i * $ratio) {
                    $size = $resolutions__value;
                }
            }
            echo '<source media="(max-width: ' . $i . 'px)" srcset="' . $image['sizes'][$size . 'x'] . '" data-size="' . $size . 'x' . '">';
        }
        echo '<img' .
          	($class !== null ? ' class="' . $class . '"' : '') .
          	($lazy === true ? ' loading="lazy"' : '') .
            ' src="' . $image['url'] . '" alt="' . $image['alt'] . '" />';
    echo '</picture>';
}
renderImage($image, 'custom-class', 0.5, 1, 1);