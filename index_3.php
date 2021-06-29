<?php
require_once("grant.php");
require_once("config.php");
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
Servises::timer_start();
//ini_set('max_execution_time', 900);
set_time_limit(0);

$pattern = '/\.jpg$/i';
$auth = new AuthOPAC();
Servises::report($auth->httpcode);
if ($auth->httpcode === 200){ //запрос при успешной авторизации
	$TOKEN = $auth->result->access_token;
}

$result_array =file("jpg_source_unique280620211736.csv");// имя файла для обработки

$COUNT = count($result_array);
echo "Колличество записей => $COUNT <br>";

$idWithProblems = array();
$item_csv = array();
$NoResource = array();
$i = 0;
foreach ($result_array as $LibId) {// цикл перебора $COUNT

echo "i=>".$i."  j=>".$LibId."<br>";

$current_Id = new FieldLibId($TOKEN,IDB, $LibId);
Servises::ErrorCodeHandler($current_Id ->class_name, $current_Id ->httpcode,$current_Id->errno);
if ($current_Id->httpcode >= 400) {
$item_csv_row = "-------\n".$LibId."\n Код - ".$current_Id->httpcode." - ".HTTP_CODE_ARRAY[$current_Id->httpcode]."\n";
    $item_csv[]= $item_csv_row;
    $idWithProblems[] = $LibId;
}else{
foreach ($current_Id ->response as $fields) {
  $field = $fields[attributes][fields];
		if (is_array($field)) {
			foreach ($field as $tags) {
				if ($tags[tag]==856) {
			 	$subField = $tags[subfields];
			 		if (is_array($subField)) {
			 			foreach ($subField as $ip_address){
			 				if ($ip_address[code] == 'u') {
			 				if (preg_match( $pattern, $ip_address[data], $matches) == 1) {

echo "Обнаружена ссылка => ".$ip_address[data]."<br>";
$oldIpAddress = $ip_address[data];
$newIpAddress = preg_filter($pattern,'.pdf', $ip_address[data]);
echo "Заменяем на ссылку => $newIpAddress <br>";

$request_correction = '{
  "data": [
    {
    "op": "add",
    "type": "marcrecord",
    "attributes":
    {
      "fields": [
      {
        "tag": "856",
        "ind1": "#",
        "ind2": "#",
        "subfields": [
        {
          "code": "u",
          "data": "'.$newIpAddress.'"
        },
        {
          "code": "2",
          "data": "Электронная версия"
        }]
      }]
    }
  },
  {
    "op": "remove",
    "type": "marcrecord",
    "attributes":
    {
      "fields": [
      {
        "tag": "856",
        "ind1": "#",
        "ind2": "#",
        "subfields": [
        {
          "code": "u",
          "data": "'.$oldIpAddress.'"
        },
        {
          "code": "2",
          "data": "Электронная версия"
        }]
      }]
    }
  }

]
}';
//echo "Request $request_correction <br>";

Servises::isJSON($request_correction);
$writeField = new setFields($TOKEN, IDB, $LibId, $request_correction);
Servises::ErrorCodeHandler($writeField ->class_name, $writeField ->httpcode,$writeField ->errno);
//echo "Результат запроса: {$writeField ->httpcode}<br>";

if ($writeField->httpcode >= 400) {
    echo "Проблемная запись => ".$LibId."<br>";
    //echo "<pre>";print_r($request_correction);echo "</pre>";
    $item_csv_row = "-------\n".$LibId.$newIpAddress."\n Код - ".$writeField->httpcode." - "."Ошибка при корррекции записи"."\n";
    $item_csv[]= $item_csv_row;
    $idWithProblems[] = $LibId;
}else{
    $serverRequest = new getServerResponse($newIpAddress,3);
    Servises::ErrorCodeHandler($serverRequest ->class_name, $serverRequest ->httpcode,$serverRequest ->errno);
//    echo "Результат запроса: {$serverRequest ->httpcode}<br>";
    echo "Проверка ссылки: {$newIpAddress}<br>";
        if ($serverRequest ->httpcode >= 400) {// Пишем содержимое в файл
        $NoResource_row = "-------\n".$LibId.$newIpAddress."\n Код - ".$serverRequest ->error."\n -  "."Ошибка существования ресурса"."\n";
          $NoResource[]= $NoResource_row;
          $idWithProblems[] = $LibId;
        }
}
}else{
  echo "Нет 856 поля или расширение не jpg <br>";
}
}
}
}
}
}
}
}
}
$i++;
} // цикл перебора $COUNT

//echo "<pre>";print_r($idWhith856);echo "</pre>";
echo 'count of records $idWithProblems = '.count($idWithProblems).'<br>';

$test = date("dmYHi");//"test"
$STATISTIC_CSV = "ProblemsCorrection".$test.".csv";
file_put_contents($STATISTIC_CSV, $item_csv, LOCK_EX);

$STATISTIC_CSV = "NoResource".$test.".csv";
file_put_contents($STATISTIC_CSV, $NoResource, LOCK_EX);

echo Servises::timer_finish() . ' сек.';
?>
