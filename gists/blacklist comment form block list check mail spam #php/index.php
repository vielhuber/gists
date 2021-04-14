function checkBlacklist($message) {
    if (!is_string($message) || trim($message) == '') {
      	return true;
    }
    $filename = sys_get_temp_dir() . '/spam-blacklist.txt';
    if( !file_exists($filename) || filemtime($filename) < strtotime('now - 1 month') ) {
        $content = @file_get_contents('https://raw.githubusercontent.com/splorp/wordpress-comment-blacklist/master/blacklist.txt');
        if( $content != '' ) {
            file_put_contents($filename, $content);
        }
    }
    $blacklist = file_get_contents($filename);
    if( $blacklist != '' && strpos($blacklist, 'cannabis') !== false ) {
        $message = strip_tags($message);
        $blacklist = trim($blacklist);
        $words = explode( PHP_EOL, $blacklist );
        foreach ( $words as $words__value ) {
            $words__value = trim( $words__value );
            if( $words__value == '' ) { continue; }
            $words__value = preg_quote( $words__value, '#' );
            $pattern = '#'.$words__value.'#i';
            if ( preg_match( $pattern, $message ) ) {
                return false;
            }
        }
    }
    return true;
}
var_dump(checkBlacklist('Es gibt im Moment in diese Mannschaft, oh, einige Spieler 100% Plagiaris vergessen ihnen Profi was sie sind. Ich lese nicht sehr viele Zeitungen, aber ich habe gehört viele Situationen. Erstens: wir haben nicht offensiv gespielt. Es gibt keine deutsche Mannschaft spielt offensiv und die Name offensiv wie Bayern. Letzte Spiel hatten wir in Platz drei Spitzen: Elber, Jancka und dann Zickler. Wir müssen nicht vergessen Zickler. Zickler ist eine Spitzen mehr, Mehmet eh mehr Basler. Ist klar diese Wörter, ist möglich verstehen, was ich hab gesagt? Danke.'));
