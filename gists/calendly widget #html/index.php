<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, minimum-scale=1" />
    <title>calendly example</title>
</head>
<body>

<?php
$settings = [
    'slug' => 'close2/anfrage',
    'colors' => [
        'bg' => '#ffffff',
        'text' => '#000000',
        'button' => '#00e18e'
    ],
    'hide_event_type_details' => true,
    'hide_gdpr_banner' => true
];

$url = 'https://calendly.com/'.$settings['slug'].''.
    '?hide_event_type_details='.($settings['hide_event_type_details']===true?'1':'0').''.
    '&hide_gdpr_banner='.($settings['hide_gdpr_banner']===true?'1':'0').''.
    '&background_color='.str_replace('#', '', $settings['colors']['bg']).''.
    '&text_color='.str_replace('#', '', $settings['colors']['text']).''.
    '&primary_color='.str_replace('#', '', $settings['colors']['button']);
?>

<!-- css/js (needs to be loaded once) -->
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>

<h2>inline widget</h2>
<div
    class="calendly-inline-widget"
    data-url="<?php echo $url; ?>"
    style="min-width:320px;height:660px;"
></div>

<h2>popup link</h2>
<p>
    Lorem ipsum dolor sit amet, consectetuer adipiscing elit.
    <a href="#" onclick="Calendly.initPopupWidget({url: '<?php echo $url; ?>'});return false;">Aenean commodo ligula</a> eget dolor.
    Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.
    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
    Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
    In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium.
    Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.
</p>

</body>
</html>