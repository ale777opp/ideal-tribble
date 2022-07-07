<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
Timer::start();
set_time_limit(0);

require('config.php');
$FLD = 'ID';
$QUERY = '*';
$LIMIT  = 500;
$POSITION = 999;

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');
print_r('limit = '.$LIMIT.'<br>');
print_r('position = '.$POSITION.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
if ($httpcode === 200) {// -----START AUTH
$Token = $auth->access_token;
$selected_ID = [];
$Statistic = array_fill_keys(array_keys($HTTP_CODE_ARRAY), 0);
$LogArray[] = "Время формирования отчёта: ".date("d.m.Y  H:i:s")."\n\r";
$item_csv[] = "Время формирования отчёта: ".date("d.m.Y  H:i:s")."\n\r";
$LogArray[] = "URL базы данных: ".$URL_API."\n\n\r";
$item_csv[] = "URL базы данных: ".$URL_API."\n\n\r";

$web_arhive_value = 0;

$QUERY = urlencode($QUERY);
$QUERY = $QUERY.LIMIT.$LIMIT.POSITION.$POSITION.OPTIONS.LINEORD;
//print_r("$QUERY <br>");
//"&limit=941&options[views]=SHOTFORM LINEORD";
//"&limit=290""&limit=150&position=840"  ."&limit=295"
['code' => $httpcode, 'content' => $result] = searchQuery($Token,$IDB,$FLD,$QUERY);

//echo "<pre> result 'links'";print_r($result['links']);echo "</pre>";

// -----START OF SELECT RECORDS
    if ($httpcode === 200) {
    $i = 0;
    foreach ($result['data'] as $value) {
        $selected_ID[$i] = $value['id'];
    //echo "<pre>";print_r($value);echo "</pre>";
    $i++;
    }
    }// -----END OF SELECT RECORDS
$i = 0;
foreach ($selected_ID as $current_ID) {
$i++;
   ['code' => $httpcode, 'content' => $result] = searchLibId($Token, $IDB, $current_ID);
if ($httpcode == 200) { // -------- START of processing the result
$current_record = $result['data'];
foreach ($current_record['attributes'] as $fields) {
    if (is_array($fields)) {
        $response['http'] = [];
        $last_date = 0;
        foreach ($fields as $tags) {
            if ($tags['tag'] == '200' OR $tags['tag'] == '300' OR $tags['tag'] == '856'){
            //print_r($tags['tag'].'<br>');
            foreach ($tags['subfields'] as $current_tag) {
            switch ($tags['tag']) {
                    case '200':
                        if ($current_tag['code'] == 'a') {
                        $response['title'] = $current_tag['data'];
                    }
                        break;
                    case '300':
                    if (!$last_date) {
                        $last_date = preg_match($FILTER_DATE,$current_tag['data']);
                        if ($last_date) {$response['date'] = $current_tag['data'];
                    $tag300_old = $tags;
                    } else {$response['date'] = 'Нет даты предыдущего обновления';}
                    }
                        break;
                    case '856':
                        if ($current_tag['code'] == 'u') $response['http'][] = $current_tag['data'];
                        break;
                    default:
                        break;
            }  // -----END OF SWITCH
            }
            }
        }
    }
    }
$response['libid'] = str_replace("%255C", "\\", $current_ID);
echo "-------<br>";
print_r($i.'. '.$response['libid'].'<br>');
print_r($response['title'].'<br>');
print_r($response['date'].'<br>');
//echo "<pre>";print_r($response['http']);echo "</pre>";

for ($j=0;$j<count($response['http']);$j++) {
$web_arhive = strstr($response['http'][$j], '*/');
if (!empty($web_arhive)) {
    $web_arhive = ltrim($web_arhive, "*/");
    $response['http'][$j] = $web_arhive;
    $web_arhive_value++;
}
}
$response['http'] = array_unique($response['http']);

foreach ($response['http'] as $values) {// --- START one http
    $value = [];
    preg_match('/http[s]?:\/\/(?:[-\w]+\.)?([-\w]+)\.\w+(?:\.\w+)?\/?/',$values, $matches, PREG_OFFSET_CAPTURE);
    $main_http = $matches[0][0];
    if ($values != $main_http) {$value[] = $main_http;$value[] = $values;
    } else {
    $value[] = $main_http;
    }
        foreach ($value as $l) {
        print_r("Обрабатываемая страница - ".$l.'<br>');
        $j=1;
        do {
            $source_response = getServerResponse($l,($TIMEOUT_DEFAULT*$j));
            $j++;
} while (($source_response['code'] == '404' OR $source_response['code'] == '0') AND $j<4);
if (array_key_exists($source_response['code'], $Statistic)) {
$server_code = "HTTP/1.1 ".$source_response['code']."  ".$source_response['content'];
$Statistic[$source_response['code']]++;
}else {
    $server_code = "Unknown http status code ".$source_response['code']."  ".htmlentities($source_response['code']);
$Statistic['noValue']++;
}
print_r($server_code."<br>");

preg_match($FILTER_DATE,$response['date'], $matches);
if (empty($matches)) $matches[0] = 0;
$item_csv_row = $response['libid']."#".$response['title']."#".$matches[0]."#".$l."#".$source_response['code']."#".$source_response['content'].";"."\n";//
}
//}

/*
if (!($source_response['code'] == '404' OR $source_response['code'] == '0' OR $response['date'] == 'Нет даты предыдущего обновления')) {

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

writeField($Token, $IDB, $current_ID, $request_remove);
writeField($Token, $IDB, $current_ID, $request_add);
}
*/
$item_csv[]= $item_csv_row;
if ($source_response['code'] != '200') {// Пишем содержимое в файл
$string_Of_Log = "-------\n\r".$response['libid']."\n\r".$response['title']."\n\r".$response['date']."\n\r"."Поверяемая ссылка - ".$l."\n\r".$server_code."\n\r";
$LogArray[] = $string_Of_Log;

}
}  //--- END one http
echo "--------";
}// -------- START of processing the result
}
} // -----END OF AUTH

/*
$fp = fopen($STATISTIC_CSV, 'w');

foreach ($item_csv as $fields) {
    fputcsv($fp, $fields);
}

fclose($fp);
*/

$test = date("dmYHi");//"test"
$STATISTIC_CSV = $STATISTIC_CSV.$test.".csv";
$LINKS_NOT_CORRECT = $LINKS_NOT_CORRECT.$test.".txt";

file_put_contents($STATISTIC_CSV, $item_csv, LOCK_EX);
file_put_contents($LINKS_NOT_CORRECT, $LogArray, LOCK_EX);
//echo "<pre>";print_r($Statistic);echo "</pre>";
print_r("<br>".'Число ссылок на "web.archive.org/web/" = '.$web_arhive_value.'<br>');
echo Timer::finish() . ' сек.';

?>