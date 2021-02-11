<?php
/*
function CBR_XML_Daily_Ru() {
    static $rates;

    if ($rates === null) {
        $rates = json_decode(file_get_contents('https://www.cbr-xml-daily.ru/daily_json.js'));
    }

    return $rates;
}

$data = CBR_XML_Daily_Ru();
*/

$request = '';
/*[
        'grant_type' => 'password',
        'client_id' => '354FE540-6100-436F-A212-7B29C4D09545',
        'client_secret' => 'rhBQCWiIufQRooTtXcH',
        'username' => 'PRGUS',
        'password' => 'wsDCrf7',
        'scope' => 'read',
    ];
*/
    curl_setopt($ch, CURLOPT_URL,"https://www.cbr-xml-daily.ru/daily_json.js");
    curl_setopt($ch, CURLOPT_POST, 1);
   // curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $data = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    print($httpcode.'<br>');
echo "Обменный курс USD по ЦБ РФ на сегодня: {$data->Valute->USD->Value}\n";
























?>