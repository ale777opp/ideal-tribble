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

function searchquery($token, $dbId, $fld, $query)
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
    $request = $URL_API.$REG_DB."/".$dbId."/records/".$libid;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request); //
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = json_decode(curl_exec($ch), true); // curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    print_r('Запрос = '.$result['links']['self'].'<br>');
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

?>