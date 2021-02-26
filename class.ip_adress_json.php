<?php

function authOPAC()
{
require('config.php');
require_once('grant.php');

    $request = [
        'grant_type' => $GRANT_TYPE,
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
        'username' => $USERNAME,
        'password' => $PASSWORD,
        'scope' => $SCOPE,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $URL_API.$REG_AUTH);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($REG_CONT_URL, $RESP_CONT_JSON));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    if ($httpcode == 200) {
    print_r('Код ответа на запрос авторизации = '.$httpcode.'<br>');
    /*
    echo "<pre>";
    print_r($response);
    echo "</pre>";
    */
    return ['code' => $httpcode, 'content' => $response];
    } else {
            print_r('Ошибка авторизации <br>');
            return false;
    }
};

function searchQuery($token, $dbId, $fld, $query)
{
require('config.php');
$query = urlencode($query);
$request = $URL_API.$REG_DB."/".$dbId.$REG_REC.$fld.$SPACE.$query;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpcode == 200) {
print_r('Код ответа на запрос поиска = '.$httpcode.'<br>');
print_r('Количество найденных записей = '.$result['meta']['count'].'<br>');
/*
echo "<pre>";
print_r($result);
echo "</pre>";
*/
return ['code' => $httpcode, 'content' => $result];
} else {
    print_r('Ошибка запроса <br>');
    return false;
}
}

function searchRecord($token, $dbId, $libid)
{
    require('config.php');
    $request_URL = $URL_API.$REG_DB."/".$dbId."/records/".$libid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request_URL); //
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = json_decode(curl_exec($ch), true); // curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
//    print_r('Запрос = '.$result['links']['self'].'<br>');
/*
    echo "<pre>";
    print_r($search);
    echo "</pre>";
*/
if ($httpcode === 200) {
            print_r('Код ответа на запрос = '.$httpcode.'<br>');
            return ['code' => $httpcode, 'content' => $result];
        } else {
            print_r('Ошибка.<br>');
            return false;
        }
} //  ---END OF searchquery

function isJSON($string){
$error = is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
print_r(json_last_error_msg());
return $error;
} //  ---END OF isJSON

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

function writeRecord($token, $dbId, $libid,$data_string)
{
require('config.php');
$request_URL = $URL_API.$REG_DB."/".$dbId."/records/".$libid;
$data_string = json_encode($data_string,JSON_UNESCAPED_UNICODE);
if(isJSON($data_string)) {echo "  JSON Valid!<br>";}else{echo "  JSON Bad-bad-bad!<br>";}
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($REG_CONT_JSON,$RESP_CONT_JSON,'authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$write = json_decode(curl_exec($ch));
$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

echo "<pre>";
print_r($write);
echo "</pre>";
/*
if ($httpcode === 200) {
            print_r('Код запроса создания записи = '.$httpcode.'<br>');
            return ['code' => $httpcode, 'content' => $write];
        } else {
            print_r('Ошибка.<br>');
            return false;
        }
 */
} //  ---END OF writequery



/*------ START OF RECORD DELETE
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response  = curl_exec($ch);
curl_close($ch);
------ END OF RECORD DELETE
 */

?>