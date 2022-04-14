<?php
call_sip_phone(
    '+49xxxxxxxxxxx', // number
    'audio.wav', // path to audio file
    '/mnt/c/path/to/tsip/tSIP_0_2_07_bin', // path to tsip; use 'C:\\Path\\To\\TSIP\\tSIP_0_2_07_bin' for native windows
    'sipgate.de', // ip
    'xxxxxxxxx', // username
    'xxxxxx' // password
);

function call_sip_phone($number, $audio, $path, $ip, $username, $password) {
    // check args
    if($number == '' || !preg_match('/^[0-9 +]+$/', $number) ) {
        throw new \Exception('wrong number format.');
    }
    if(!file_exists($audio)) {
        throw new \Exception('audio missing.');
    }
    if(!is_dir($path) || !file_exists($path.'/tSIP.exe')) {
        throw new \Exception('tsip missing.');
    }

    // format number
    $number = (string)$number;
    $number = str_replace(' ', '', $number);
    if( mb_strpos($number, '0') === '0' ) {
        $number = '+49'.mb_substr($number, 1);
    }
    if( mb_strpos($number, '+') !== 0 ) {
        $number = '+'.$number;
    }

    // create status file if not exists
    if( !file_exists($path.'/status.log') ) {
        file_put_contents($path.'/status.log', '0');
    }

    // if status file says state is > 0, wait
    $max = 10;
    while(file_get_contents($path.'/status.log') != '0') {
        sleep(1);
        $max--; if( $max === 0 ) { throw new \Exception('max while stack exceeded.'); }
    }

    // create lua file (inspired by https://tomeko.net/software/SIPclient/howto/playing_audio_after_answering.php)
    $lua = <<<EOD
    function writeStatus(msg)
        file = io.open("status.log", "w")
        file:write(msg)
        file:close(file)
    end
    function playAudio(audio_file_name, audio_file_length)
        SwitchAudioSource("aufile", audio_file_name)
        for i=1, audio_file_length*10, 1
        do
            Sleep(100)
            call_state = GetCallState()
            if call_state == 0 then
                -- CALL_STATE_CLOSED
                break
            end
        end
        SwitchAudioSource("winwave", "")
    end
    local audio_file_name = "audio.wav"   
    local audio_file_length = 40
    local callState = GetCallState()
    writeStatus(GetCallState())
    if callState ~= 6 then
        return
    end
    playAudio(audio_file_name, audio_file_length)
    writeStatus(GetCallState())
EOD;
    file_put_contents($path.'/scripts/PlayAudioFileAuto.lua', $lua);

    // modify config file to run that lua file
    $json = file_get_contents($path.'/tSIP.json');
    foreach([
        'OnCallState' => 'PlayAudioFileAuto.lua',
        'reg_server' => $ip.':5060',
        'user' => $username,
        'pwd' => $password
    ] as $data__key=>$data__value) {
        $pos1 = mb_strpos($json, '"'.$data__key.'" : "');
        $pos2 = mb_strpos($json, '"', $pos1 + mb_strlen('"'.$data__key.'" : "'))+1;
        $json = mb_substr($json, 0, $pos1).'"'.$data__key.'" : "'.$data__value.'"'.mb_substr($json, $pos2);
    }
    file_put_contents($path.'/tSIP.json', $json);

    // place wav file
    copy($audio, $path.'/audio.wav');

    // run tsip from command line
    shell_exec($path.'/tSIP.exe /tsip='.$number);

    // wait until state is 0 again
    sleep(3);
    $max = 100;
    while(file_get_contents($path.'/status.log') != '0') {
        sleep(1);
        $max--; if( $max === 0 ) { throw new \Exception('max while stack exceeded.'); }
    }
}
