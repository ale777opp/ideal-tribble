<?php
print_r($_SERVER['request_time']);
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');

$FLD = 'ID';
$QUERY = '*';

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
if ($httpcode === 200) {
$Token = $auth->access_token;
['code' => $httpcode, 'content' =>$record] = searchQuery($Token,$IDB,$FLD,$QUERY);
    if ($httpcode === 200) {
    $i = 0;
    print_r($record['links']['next'].'<br>');
    foreach ($record['data'] as $list) {
        $i++;
        print_r($i.'.  '.$list['id'].'<br>');
        foreach ($list['attributes'] as $fields) {
            if (is_array($fields)) {
       foreach ($fields as $field) {
        if ($field['tag'] == '856') { //$field[tag] == '200' OR $field[tag] == '300' OR
           // print_r($field['tag']);
                if (count($field['subfields']) > 0 ) {
                    foreach ($field['subfields'] as $f) {
                    $http_code = getResponseServer($f['data']);
                    echo "  $f[data] ";
                    echo "<br>";
                    echo " $http_code ";
                    }
                }
                echo "<br>";
                }
        }
            }
            }
            }
        } else {
            return false;
        }
} // --- END OF searchOPAC
//print_r($_SERVER['request_time']);

function getResponseServer($url) {
    $curlInit = curl_init($url); // Инициализация cURL
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10); // Установка параметров запроса
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);
    $response = curl_exec($curlInit); // Выполнение запроса
    //$http_code = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
    //echo "HTTP/1.1 $http_code <br>";
    curl_close($curlInit); // закрываем CURL


//$pieces = explode(" ", $response);

//print_r(is_string($response));
/*
echo '<pre>';
print_r($response);
echo '</pre>';
*/
    return $response;
} //---END OF getServerResponse
?>

