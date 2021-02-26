<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');

$FLD = 'ID';
$QUERY = '*';

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
$Token = $auth->access_token;
$selected_ID = [];

if ($httpcode === 200) {// -----START OF SELECT RECORDS
['code' => $httpcode, 'content' => $result] = searchQuery($Token, $IDB, $FLD,$QUERY);
    if ($httpcode === 200) {
    $i = 0;
    foreach ($result['data'] as $value) {
        $selected_ID[$i] = $value['id'];
    $i++;
    }
    }
} // -----END OF SELECT RECORDS
foreach ($selected_ID as $current_ID) {// -----START OF PARCER
print_r($current_ID.'<br>');
   ['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, $current_ID);
if ($httpcode == 200) { // -------- START of processing the result

foreach ($result['data']['attributes'] as $fields) {
    if (is_array($fields)) {
        foreach ($fields as $tags) {
            if ($tags['tag'] == '200' OR $tags['tag'] == '300' OR $tags['tag'] == '856'){
            foreach ($tags['subfields'] as $current_tag) {
            switch ($tags['tag']) {
                    case '200':
                        if ($current_tag['code'] == 'a') $response_title = $current_tag['data'];
                        break;
                    case '300':
                    $last_date = preg_match($FILTER_DATE,$current_tag['data']);

                    if ($last_date) {$response_date = $current_tag['data'];
                    } else {$response_date = 'Нет даты предыдущего обновления';}
                        break;
                    case '856':
                        if ($current_tag['code'] == 'u') $response_http = $current_tag['data'];
                        break;
                    default:
                        break;
            }  // -----END OF SWITCH
            }
            }
        }
    }
    }
echo "<pre> ---";
print_r($response_title.'<br>');
print_r($response_date.'<br>');
print_r($response_http.'<br>');
$source_response = getServerResponse($response_http);
print_r($source_response);
($source_response == '200' OR $source_response == '30*') ? print_r(" - Сайт жив.<br>") : print_r(" - Сайт умер.<br>");
echo "---</pre>";
}// -------- START of processing the result
}// -----END OF PARCER

/*
require_once('request.php');
writeRecord($Token, $IDB, $LIBID,$record_field);
*/
?>