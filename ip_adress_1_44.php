<?php

error_reporting(0);

$IDB = '425';
/*
$FLD = 'TI';
$QUERY = 'Северные крепости';
*/
$FLD = 'ID';
$QUERY = '*';



print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

searchOPAC($IDB, $FLD, urlencode($QUERY));

function searchOPAC($idb, $fld, $query){

    $ch = curl_init();
    $request = [
        'grant_type' => 'password',
        'client_id' => '354FE540-6100-436F-A212-7B29C4D09545',
        'client_secret' => 'rhBQCWiIufQRooTtXcH',
        'username' => 'PRGUS',
        'password' => 'wsDCrf7',
        'scope' => 'read',
    ];

    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $auth = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    print_r('Код запроса авторизации = '.$httpcode.'<br>');
    /*
    print_r('Токен авторизации <br>');
    echo "<pre>";
    print_r($auth);
    echo "</pre>";
    */
    if ($httpcode === 200) {
        $record = searchquery($auth->access_token, $idb, $fld, $query);
        $i = 0;
        if ($record) {
            foreach ($record['data'] as $list) {
                    $i++;
        print_r('Запись № '.$i.'<br>');
                foreach ($list as $l) {
                    //echo "$l[leader]"; !BREVE
                    foreach ($l['fields'] as $field) {
                        if ($field[tag] == '856' OR $field[tag] == '300') { //$field[tag] == '200' OR $field[tag] == '300' OR
                            echo " $field[tag]   "; // !BREVE $filed[ind1] $field[ind2]$field[data]
                        if (count($field['subfields']) > 0 ) {
                            foreach ($field['subfields'] as $f) {
                                if ($field[tag] == '856'){
                                $http_code = getServerResponse($f[data]);
                                echo "  $f[data]  HTTP/1.1 $http_code ";//!BREVE  $f[code]
                                }else{
                                    $lastReadDate = preg_match_all('/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/',$f[data],$out, PREG_OFFSET_CAPTURE);
                                   if ($lastReadDate){print_r('Дата обращения к ресурсу - '.$out[0][0][0].'<br>');}
                                }
                                }
                        }
                        echo "<br>";
                        } // -- END SELECT TAG 856 AND TAG 300

                        }
                    }
                }
            }
        } else {
            return false;
        }
} // --- END OF searchOPAC

function searchquery($token, $dbId, $fld, $query) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/databases/" . $dbId . "/records?filter[query]=". $fld ."%20" . $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.api+json', 'authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $search = json_decode(curl_exec($ch), true);
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    print_r('Код запроса ответа = '.$httpcode.'<br>');
    /*
    echo "<pre>";
    print_r($search);
    echo "</pre>";
    */
    if ($httpcode == 200) {
        if ( $search['meta']['count'] > 0 ) {
            print_r('Количество найденных записей = '.$search['meta']['count'].'<br>');
            return $search;
        } else {
            print_r('Записей нет.<br>');
            return false;
        }
    }
} //  ---END OF searchquery

function getServerResponse($url) {
    $curlInit = curl_init($url); // Инициализация cURL
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10); // Установка параметров запроса
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($curlInit); // Выполнение запроса
    $http_code = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
    //echo "HTTP/1.1 $http_code <br>";
    curl_close($curlInit); // закрываем CURL
/*
echo '<pre>';
print_r($response);
echo '</pre>';
*/
    return $http_code;
} //---END OF getServerResponse
?>
