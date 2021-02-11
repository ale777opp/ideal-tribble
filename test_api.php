<?php

error_reporting(0);

    $ch = curl_init();

    $request = [
        'grant_type' => 'password',
        'client_id' => '354FE540-6100-436F-A212-7B29C4D09545',
        'client_secret' => 'rhBQCWiIufQRooTtXcH',
        'username' => 'PRGUS',
        'password' => 'wsDCrf7',
        'scope' => 'read',
    ];

    curl_setopt($ch, CURLOPT_URL, "http://opac64-test.liart.local/api/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $auth = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    echo "<pre>";
    print_r($auth);
    echo "</pre>";

   	print_r('Код авторизации = '.$httpcode.'<br>');

//}  !-------------- END OF function searchOPAC{} ----------------------------

?>