<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');

$FLD = 'ID';
$QUERY = '*';

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');
$UsersArray[] = '';

['code' => $httpcode, 'content' => $auth] = authOPAC();
if ($httpcode === 200) {
$Token = $auth->access_token;

//$query = urlencode($QUERY);
//"%28dateInput GE 2014%29%20AND%20%28dateCorrection%20LE%202017%29&sort=dateCorrection%20desc&limit=1"
$query = "%28dateInput%20GE%202014%29";
//%20AND%20%28dateCorrection%20LE%202017%29&sort=dateCorrection%20desc&limit=1"
$request = $URL_API."/users?filter[query]=".$query."&limit=71";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array($RESP_CONT_JSON, 'authorization: Bearer ' . $Token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);
//echo "<pre>";print_r($result);echo "</pre>";
}
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpcode == 200) {
    print_r('Код ответа на запрос поиска = '.$httpcode.'<br>');
    print_r('Количество найденных записей = '.$result['meta']['count'].'<br>');

echo '---------------<br>';
foreach ($result['data'] as $value) {
    //print_r($value['id'].'<br>');
    print_r('login = '.$value['attributes']['login'].'<br>');
    print_r('type = '.$value['attributes']['type'].'<br>');
    print_r('fio = '.$value['attributes']['fio'].'<br>');
    print_r('id = '.$value['attributes']['id'].'<br>');
    //echo "<pre>";print_r($key);echo "</pre>";
echo '---------------<br>';
$string_Of_Users = "-------\n"."login = ".$value['attributes']['login']."\n"."type = ".$value['attributes']['type']."\n"."fio = ".$value['attributes']['fio']."\n"."id = ".$value['attributes']['id']."\n";
$UsersArray[] = $string_Of_Users;
}
} else {
    print_r($httpcode."  ".$HTTP_CODE_ARRAY[$httpcode].'<br>');
    return false;
}

$USERS = "users.txt";
file_put_contents($USERS, $UsersArray, LOCK_EX);
//print_r($USERS.'<br>');
/*
curl -X GET "https://opac-global.ru/api/v1/users?filter[query]=%28dateInput%20GE%202014%29%20AND%20%28dateCorrection%20LE%202017%29&sort=dateCorrection%20desc&limit=1" -H "accept: application/vnd.api+json"

https://opac-global.ru/api/v1/users?filter[query]=%28dateInput%20GE%202014%29%20AND%20%28dateCorrection%20LE%202017%29&sort=dateCorrection%20desc&limit=1

*/
?>

