<?php
class Timer
{
    private static $start = .0;
    static function start()
    {
        self::$start = microtime(true);
    }
    static function finish()
    {
        return microtime(true) - self::$start;
    }
}

function authOPAC()
{
require('config.php');
require_once('grant.php');
$request = [
    'grant_type' => GRANT_TYPE,
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
    'username' => USERNAME,
    'password' => PASSWORD,
    'scope' => SCOPE,
];
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $URL_API.$REG_AUTH);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
curl_setopt($ch, CURLOPT_HTTPHEADER, array($REG_CONT_URL, $RESP_CONT_JSON));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = json_decode(curl_exec($ch));
$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch); // закрываем CURL
if ($httpcode == 200) {
    print_r('Код ответа на запрос авторизации = '.$httpcode.'<br>');
    return ['code' => $httpcode, 'content' => $response];
} else {
        print_r('Ошибка авторизации. '.$httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
        return false;
}
};

function searchQuery($token, $dbId, $fld, $query)
{
require('config.php');
$query = urlencode($query);
$request = $URL_API.$REG_DB."/".$dbId.$REG_REC.$fld.$SPACE.$query."&limit=150&position=840";//"&limit=290"
//print_r($request.'<br>');
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);

//echo "<pre>";print_r($result);echo "</pre>";

$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    print_r('Код ответа на запрос поиска = '.$httpcode.'<br>');
    print_r('Количество найденных записей = '.$result['meta']['count'].'<br>');
    return ['code' => $httpcode, 'content' => $result];
} else {
    print_r($httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
    return false;
}
}

function searchLibId($token, $dbId, $libid)
{
require('config.php');
$request_URL = $URL_API.$REG_DB."/".$dbId."/records/".$libid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_URL); //
curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true); // curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
curl_close($ch); // закрываем CURL
if ($httpcode === 200) {
    //print_r('Код ответа на запрос по LIBID = '.$httpcode.'<br>');
    return ['code' => $httpcode, 'content' => $result];
} else {
    print_r('Ошибка запроса по LIBID. '.$httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
    return false;
}
} //  ---END OF searchLibId

function isJSON($string){
$error = is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? false : true ;
if ($error) print_r(json_last_error_msg());
return $error;
} //  ---END OF isJSON

function getServerResponse($url,$timeout)
{
require('config.php');
$ch = curl_init($url); // Инициализация cURL
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout); // Установка параметров запроса
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_NOBODY,true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$response = curl_exec($ch); // Выполнение запроса
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch); // закрываем CURL
if ($http_code !== NULL) {
    if (array_key_exists($http_code, $HTTP_CODE_ARRAY)) {
    $text = $HTTP_CODE_ARRAY[$http_code];
}
    else  $text = 'Unknown http status code "' . htmlentities($http_code) . '"';
}
return ['code' => $http_code, 'content' => $text];
} //---END OF getServerResponse

function writeField($token, $dbId, $libid,$data_string)
{
require('config.php');
$request_URL = $URL_API.$REG_DB."/".$dbId."/records/".$libid;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request_URL);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($REG_CONT_JSON,$RESP_CONT_JSON,'authorization: Bearer '.$token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$write = json_decode(curl_exec($ch));
$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
if ($httpcode === 200) {
    //print_r('Код запроса изменения записи = '.$httpcode.'<br>');
    return ['code' => $httpcode, 'content' => $write];
    } else {
    print_r('Ошибка записи. '.$httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
    return false;
}
} //  ---END OF writeField

function getLibIdList($token,$dbId,$fld,$query)
{
require('config.php');
$idList = [];
$query = urlencode($query);
$request = $URL_API.$REG_DB."/".$dbId."/indexes/".$fld."?filter[query]=".$query."&limit=941";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON,'authorization: Bearer ' .$token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
if ($httpcode == 200) {
    print_r('Код ответа на запрос поиска = '.$httpcode.'<br>');
    $i = 0;
    foreach ($result['data'] as $value) {
        $idList[$i] = $value['attributes']['value'];
 //   echo "-------<br>";
 //   print_r($i.'. '.$selected_ID[$i].'<br>');
    $i++;
    }
    return $idList;
} else {
    print_r('Ошибка запроса поиска по шаблону. '.$httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
}
} // -----END OF getLibIdList

//echo "<pre>";print_r($current_tag);echo "</pre>";

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