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
    if ($result) {
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


        /*    foreach ($result['data'] as $list) {
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

           echo "<pre>";
            print_r($result['data']);
            echo "</pre>";
*/
        } else {
            return false;
        }
    }
?>

