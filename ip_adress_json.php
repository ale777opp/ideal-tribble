<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');

$FLD = 'TI';
$QUERY = 'Южные крепости';
//$QUERY = 'Северные крепости';

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
$Token = $auth->access_token;

if ($httpcode === 200) {
['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, $LIBID);
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
require_once('request.php');
writeRecord($Token, $IDB, $LIBID,$record_field);
}

?>