<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
require('config.php');

$FLD = 'ID';
$QUERY = '*';
/*
$FLD = 'TI';
$QUERY = 'северные крепости';
*/
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
$i=0;
foreach ($selected_ID as $current_ID) {// -----START OF PARCER
$i++;
echo "-------<br>";
print_r($i.'. '.$current_ID.'<br>');
   ['code' => $httpcode, 'content' => $result] = searchRecord($Token, $IDB, $current_ID);
if ($httpcode == 200) { // -------- START of processing the result
$current_record = $result['data'];
foreach ($current_record['attributes'] as $fields) {
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
                    $tag300_old = $tags;
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
print_r($response_title.'<br>');
print_r($response_date.'<br>');
print_r($response_http.'<br>');
$source_response = getServerResponse($response_http);
if ($source_response == '200') print_r("HTTP/1.1 ".$source_response." OK ,- cайт доступен.<br>");
else if($source_response == '301') print_r("HTTP/1.1 ".$source_response." OK ,caйт доступен(переадресован).<br>");
else print_r("HTTP/1.1 ".$source_response." - ,caйт не доступен.<br>");


$tag300_new = $tag300_old;
$tag300_new['subfields'][0]['data'] = preg_filter($FILTER_DATE,$TODAY,$tag300_old['subfields'][0]['data']);

$tag300_new_json = json_encode($tag300_new,JSON_UNESCAPED_UNICODE);
$tag300_old_json = json_encode($tag300_old,JSON_UNESCAPED_UNICODE);

$req_begin_add = '{"data":[{"op":"add","type":"marcrecord","attributes":{"fields":[';
$req_begin_remove = '{"data":[{"op":"remove","type":"marcrecord","attributes":{"fields":[';
$req_end = ']}}]}';

$request_add = $req_begin_add.$tag300_new_json.$req_end;
$request_remove = $req_begin_remove.$tag300_old_json.$req_end;

isJSON($request_add);
isJSON($request_remove);

//$request_add = json_decode($request_add);
//$request_remove = json_decode($request_remove);

writeRecord($Token, $IDB, $current_ID, $request_remove);
writeRecord($Token, $IDB, $current_ID, $request_add);
echo "--------";
}// -------- START of processing the result
}// -----END OF PARCER
?>