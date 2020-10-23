function youtube_thumbnail_url($id) {
    $filename = md5($id).'.jpg';
    $fallback = '_fallback.jpg';
    $folder_name = 'youtube-thumbnail';
    $folder_public = wp_upload_dir()['baseurl'].'/'.$folder_name;
    $folder_path = wp_upload_dir()['basedir'].'/'.$folder_name;
    if( !file_exists($folder_path) ) {
        mkdir($folder_path);
    }
    if( file_exists($folder_path.'/'.$filename) ) {
        return $folder_public.'/'.$filename;
    }
    $content = @file_get_contents('https://img.youtube.com/vi/'.$id.'/0.jpg');
    if( $content == '' ) {
        return $folder_public.'/'.$fallback;
    }
    file_put_contents($folder_path.'/'.$filename, $content);
    return $folder_public.'/'.$filename;
}

echo '<img src="'.youtube_thumbnail_url('FoPNYf4dx2s').'" />';