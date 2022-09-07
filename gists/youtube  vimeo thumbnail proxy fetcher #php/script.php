function thumbnail_url($id, $type) {
    $filename = md5($id).'.jpg';
    $fallback = '_fallback.jpg';
    $folder_name = 'video-thumbnails';
    $folder_public = wp_upload_dir()['baseurl'].'/'.$folder_name;
    $folder_path = wp_upload_dir()['basedir'].'/'.$folder_name;
    if( !file_exists($folder_path) ) {
        mkdir($folder_path);
    }
    if( file_exists($folder_path.'/'.$filename) ) {
        return $folder_public.'/'.$filename;
    }
    if($type === 'youtube') {
        $content = @file_get_contents('https://img.youtube.com/vi/'.$id.'/0.jpg');
    }
    if($type === 'vimeo') {
        $content = @file_get_contents('http://vimeo.com/api/v2/video/' . $this->queryString['vimeoid'] . '.json');
        if ($content != '') {
            $content = json_decode($content);
            $content = @file_get_contents($content[0]->thumbnail_large);
        }
    }
    if( $content == '' ) {
        return $folder_public.'/'.$fallback;
    }
    file_put_contents($folder_path.'/'.$filename, $content);
    return $folder_public.'/'.$filename;
}

echo '<img src="'.thumbnail_url('FoPNYf4dx2s','youtube').'" />';
echo '<img src="'.thumbnail_url('472170447','vimeo').'" />';