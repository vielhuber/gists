<?php
add_filter( 'upload_mimes', function( $existing_mimes = [] )
{
    $existing_mimes['vcf'] = 'text/x-vcard';
    $existing_mimes['svg'] = 'image/svg+xml';
  	$existing_mimes['ico'] = 'image/x-icon';
    return $existing_mimes;
});
// this is needed for all wordpress versions >= 4.7.1
// this is also needed for svg files without proper mime types (without the <?xml tag inside!)
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes)
{
  $filetype = wp_check_filetype( $filename, $mimes );
  return [
      'ext' => $filetype['ext'],
      'type' => $filetype['type'],
      'proper_filename' => $data['proper_filename']
  ];
}, 10, 4 );