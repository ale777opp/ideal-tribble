<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');
print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
$Token = $auth->access_token;

if ($httpcode === 200) {
['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, 'RSLA%255CBIBL%255C0000474020');// $LIBID
}
if ($httpcode == 200) {
    /*
    $write_row = ["9" => "200","11" =>"300","12" =>"324","13" =>"326","14" =>"330","30" =>"856"];
    foreach ($write_row as $key => $value) {
        print_r($result['data']['attributes']['fields'][$key]['tag'].'  ');
        print_r($result['data']['attributes']['fields'][$key]['subfields'][0]['data'].'<br>'); // 200 => 9,300 => 11,324 => 12,326 => 13,330 => 14,856 => 30
    }

echo "<pre>";
print_r($result);
echo "</pre>";

/*
foreach ($result['data'] as $list) {
                foreach ($list as $l) {
                    echo "$l[leader]"; //
                    foreach ($l['fields'] as $field) {
                       // if ($field[tag] == '200' OR $field[tag] == '300' OR $field[tag] == '856') {
                            echo "$field[tag]$field[data] $filed[ind1] $field[ind2] "; // !BREVE
                        if (count($field['subfields']) > 0 ) {
                            foreach ($field['subfields'] as $f) {
                                echo "$f[data]$f[code]"; //!BREVE
                            }
                        }
                        echo "<br>";
                    //    }
                    }
                }
            }
*/

}
// ------ BEGIN OF CHANGE OF DB RECORD
require_once('request.php');

$data_string = json_encode($record_field_add,JSON_UNESCAPED_UNICODE);
if(isJSON($data_string)) {echo "  JSON Valid!<br>";}else{echo "  JSON Bad-bad-bad!<br>";}

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/databases/425/records/RSLA%255CBIBL%255C0000474021");
curl_setopt($ch, CURLOPT_HTTPHEADER, array( 'Content-Type: application/json','Accept: application/vnd.api+json','Content-Length: ' . strlen($data_string),'authorization: Bearer ' . $Token));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);

curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);


curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$write = json_decode(curl_exec($ch));
$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
print_r('Код запроса создания записи = '.$httpcode.'<br>');

echo "<pre>";
print_r($write);
echo "</pre>";
// ------ END OF CHANGE OF DB RECORD

?>