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
['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, $LIBID);
}
if ($httpcode == 200) {
    $write_row = ["9" => "200","11" =>"300","12" =>"324","13" =>"326","14" =>"330","30" =>"856"];
    foreach ($write_row as $key => $value) {
        print_r($result['data']['attributes']['fields'][$key]['tag'].'  ');
        print_r($result['data']['attributes']['fields'][$key]['subfields'][0]['data'].'<br>'); // 200 => 9,300 => 11,324 => 12,326 => 13,330 => 14,856 => 30
    }
}

?>