$whatsapp_folder = $_SERVER['DOCUMENT_ROOT'] . '/path/to/script';

@unlink($whatsapp_folder . '/status.json');
@unlink($whatsapp_folder . '/qr.json');
@unlink($whatsapp_folder . '/data.json');

if(PHP_OS_FAMILY === 'Windows') {
  	define('NODE_PATH', '"C:\Program Files\nodejs\node"');
    file_put_contents($whatsapp_folder . '/run.bat', '@echo off' . PHP_EOL . 'cd /d ' . $whatsapp_folder . '' . PHP_EOL . 'start /B "" ' . NODE_PATH . ' script.js > NUL 2>&1' );
    pclose(popen('start /B cmd /c ' . $whatsapp_folder . '/run.bat', 'r'));
}
else {
  	define('NODE_PATH', '/root/.nvm/versions/node/v23.5.0/bin/node');
	shell_exec('cd ' . $whatsapp_folder . ' && ' . NODE_PATH . ' --no-deprecation script.js > /dev/null 2>&1 &');
}

while (
    !file_exists($whatsapp_folder . '/status.json') ||
    strpos(json_decode(file_get_contents($whatsapp_folder . '/status.json'))->message, 'finished') === false
) {
    sleep(1);
}

if (file_exists($whatsapp_folder . '/qr.json')) {
    echo 'QR-Code scannen, um Zugriff zu erhalten!' .
        '<br/>' ;
    echo 'Nach dem Scannen bitte mind. 1 Minute warten, bevor das Script erneut ausgeführt wird!' . '<br/>';
    echo '<textarea style="width: 500px;height: 500px;">';
    echo json_decode(file_get_contents($whatsapp_folder . '/qr.json'))->data->img;
    echo '</textarea>';
  	echo '<br/>';
    @unlink($whatsapp_folder . '/qr.json');
} else {
    echo 'Kein QR-Code vorhanden!<br/>';
}

if (file_exists($whatsapp_folder . '/data.json')) {
    $data = json_decode(file_get_contents($whatsapp_folder . '/data.json'));
    foreach ($data as $data__value) {
        print_r($data__value);
    }
} else {
    echo 'Keine Daten vorhanden!<br/>';
}

@unlink($whatsapp_folder . '/status.json');
@unlink($whatsapp_folder . '/qr.json');
@unlink($whatsapp_folder . '/data.json');