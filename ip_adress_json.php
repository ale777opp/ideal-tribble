<?php
error_reporting(E_ALL);
/*запрос:
Request URL
https://opac-global.ru/api/v1/databases/20/records/LIBID%25255CBIBL%25255C0000000001?options[views]=SHOTFORM%2CLINEORD
https://opac-global.ru/api/v1/
databases/ - 20
records/  - LIBID%25255CBIBL%25255C0000000001
?options[views]=
SHOTFORM%2CLINEORD (поле пробел значение)
--------------
"accept: application/vnd.api+json" - добавить в cURL

запись:
Request URL
https://opac-global.ru/api/v1/databases/20/records/LIBID%25255CBIBL%25255C0000000001
"accept: application/vnd.api+json"
"Content-Type: application/vnd.api+json" - добавление в cURL
 -d "{
\"data\":[{\"op\":\"add\",
\"type\":\"marcrecord\",\"attributes\":{\"fields\":[{\"tag\":\"003\",\"data\":\"http://localhost/records/record.xml\"},
{\"tag\":\"856\",\"ind1\":\"4\",\"ind2\":\"0\",\"subfields\":[{\"code\":\"u\",\"data\":\"http://localhost/files/document.pdf\"}]}]}},
{\"op\":\"remove\",
\"type\":\"marcrecord\",\"attributes\":{\"fields\":[{\"tag\":\"003\",\"data\":\"http://localhost/records/record.xml\"}]}}]}"
*/
require_once('class.ip_adress_json.php');
require('config.php');
print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
$Token = $auth->access_token;

if ($httpcode === 200) {
['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, $LIBID);
}
if ($httpcode == 200) {
        print_r($result['data']['attributes']['fields'][9]['tag'].'  ');
        print_r($result['data']['attributes']['fields'][9]['subfields'][0]['data'].'<br>'); // 200
        print_r($result['data']['attributes']['fields'][11]['tag'].'  '); // 300
        print_r($result['data']['attributes']['fields'][11]['subfields'][0]['data'].'<br>'); // 300
        print_r($result['data']['attributes']['fields'][12]['tag'].'  '); // 300
        print_r($result['data']['attributes']['fields'][12]['subfields'][0]['data'].'<br>'); // 300
        print_r($result['data']['attributes']['fields'][13]['tag'].'  '); // 300
        print_r($result['data']['attributes']['fields'][13]['subfields'][0]['data'].'<br>'); // 300
        print_r($result['data']['attributes']['fields'][14]['tag'].'  '); // 300
        print_r($result['data']['attributes']['fields'][14]['subfields'][0]['data'].'<br>'); // 300
        print_r($result['data']['attributes']['fields'][30]['tag'].'  ');
    	print_r($result['data']['attributes']['fields'][30]['subfields'][0]['data'].'<br>'); // 856
}
// ------ BEGIN OF CHANGE OF DB RECORD
$data_string = '
{data":{"type":"marcrecord"},"attributes":{"leader":"02450nii0 22003853i 450 ","fields":[{"tag":"100","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"20131002a20019999m##y0rusy0189####ca"}]},{"tag":"101","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"rus"}]},{"tag":"102","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"RU"}]},{"tag":"106","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"s"}]},{"tag":"110","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"gp|z|||0|||"}]},{"tag":"135","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"vrcn#nnnunnun"}]},{"tag":"139","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"ucbb"}]},{"tag":"200","ind1":"1","ind2":"#","subfields":[{"code":"a","data":"Северные крепости"},{"code":"b","data":"Электронный ресурс"},{"code":"d","data":"Northern Fortress"},{"code":"e","data":"описания замечательных крепостей северо-запада России и сопредельных стран, снабженныя картами, планами и фотографическими изображениями оных"},{"code":"f","data":"Алексей Госс"},{"code":"z","data":"eng"}]},{"tag":"230","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Электрон. дан."}]},{"tag":"300","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Загл. с домашней страницы сайта"}]},{"tag":"300","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Дата обращения к ресурсу 02.10.2013"}]},{"tag":"324","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Дата обращения"}]},{"tag":"336","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Электрон. текст, граф. дан."}]},{"tag":"337","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Режим доступа:http://www.nortfort.ru/"}]},{"tag":"510","ind1":"1","ind2":"#","subfields":[{"code":"a","data":"Northern Fortress"},{"code":"e","data":"the remarkable fortresses of northwest Russia and Scandinavia with their detailed descriptions, history reviews, maps, plans and some photographic images"},{"code":"z","data":"eng"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Крепости"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Россия"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Крепости"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Эстония"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Крепости"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Швеция"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Крепости"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Финляндия"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Крепости"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Норвегия"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Замки"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Россия"},{"code":"j","data":"Планы"},{"code":"j","data":"Схемы"},{"code":"j","data":"Чертежи"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Фортификационные сооружения"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Россия"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Фортификационные сооружения"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Финляндия"},{"code":"2","data":"rsla-sh"}]},{"tag":"606","ind1":"0","ind2":"#","subfields":[{"code":"a","data":"Фортификационные сооружения"},{"code":"x","data":"Архитектура"},{"code":"y","data":"Швеция"},{"code":"2","data":"rsla-sh"}]},{"tag":"702","ind1":"#","ind2":"1","subfields":[{"code":"a","data":"Госс"},{"code":"b","data":"А."},{"code":"g","data":"Алексей"},{"code":"4","data":"260"},{"code":"4","data":"220"}]},{"tag":"801","ind1":"#","ind2":"0","subfields":[{"code":"a","data":"RU"},{"code":"b","data":"РГБИ"},{"code":"c","data":"20131002"},{"code":"g","data":"rcr"}]},{"tag":"801","ind1":"#","ind2":"1","subfields":[{"code":"a","data":"RU"},{"code":"b","data":"РГБИ"},{"code":"c","data":"20131002"}]},{"tag":"830","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"101"}]},{"tag":"856","ind1":"4","ind2":"0","subfields":[{"code":"u","data":"http://www.nortfort.ru/"}]},{"tag":"909","ind1":"#","ind2":"#","subfields":[{"code":"a","data":"Сетевой ресурс"}]}]}}}';
//$data_string = json_encode($request,JSON_UNESCAPED_UNICODE,JSON_UNESCAPED_LINE_TERMINATORS);

//$data_string = '{\"data\":{\"type\":\"marcrecord\",\"attributes\":{\"leader\":\" nam 22 450 \",\"fields\":[{\"tag\":\"100\",\"ind1\":\" \",\"ind2\":\" \",\"subfields\":[{\"code\":\"a\",\"data\":\"19980713d1997 u y0rusy0189 ca\"}]},{\"tag\":\"200\",\"ind1\":\"1\",\"ind2\":\" \",\"subfields\":[{\"code\":\"a\",\"data\":\"Том 1\"}]},{\"tag\":\"461\",\"ind1\":\" \",\"ind2\":\"0\",\"subfields\":[{\"code\":\"1\",\"data\":{\"tag\":\"200\",\"ind1\":\"1\",\"ind2\":\" \",\"subfields\":[{\"code\":\"a\",\"data\":\"Война и мир\"}]}}]},{\"tag\":\"801\",\"ind1\":\" \",\"ind2\":\"0\",\"subfields\":[{\"code\":\"a\",\"data\":\"RU\"},{\"code\":\"b\",\"data\":\"LIBID\"},{\"code\":\"c\",\"data\":\"19980713\"},{\"code\":\"g\",\"data\":\"PSBO\"}]},{\"tag\":\"801\",\"ind1\":\" \",\"ind2\":\"1\",\"subfields\":[{\"code\":\"a\",\"data\":\"RU\"},{\"code\":\"b\",\"data\":\"LIBID\"},{\"code\":\"c\",\"data\":\"19980713\"}]}],\"template\":\"ОПОЗНАВАТЕЛЬНАЯ ЗАПИСЬ\"}}}';
// $request = array('data'=> array('attributes' => array('fields' => array([12] =>array('subfields' => array([0] =>array('data' => 'test')))))));
//$idRecord = 'RSLA\\\BIBL\\\0000214413';
//$question = "http://192.168.1.44/api/v1/databases/425/records/";
//$data_string = addslashes($data_string);
$control = json_decode($data_string);
echo "<pre>";
print_r($control);
echo 'вывод';
echo "</pre>";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/databases/425/records/");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);


curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 1);


    curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','Accept: application/vnd.api+json','Content-Length: ' . strlen($data_string),'authorization: Bearer ' . $Token)); //
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
     $httpcode = curl_getinfo($ch, CURLINFO_HEADER_OUT);
    $write = json_decode(curl_exec($ch));
    //if(curl_close($ch)){$write = json_decode(curl_exec($ch));}
    //print_r('Токен авторизации = '.$token.'<br>');

    echo "<pre>";
    print_r($write);
    echo "</pre>";

    echo "<pre>";
    print_r($httpcode);
    echo "</pre>";


    print_r('Код запроса создания записи = '.$httpcode.'<br>');
// ------ END OF CHANGE OF DB RECORD
?>