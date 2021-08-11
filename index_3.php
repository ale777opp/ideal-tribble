<?php
require_once("grant.php");
require_once("config.php");
set_time_limit(0);
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
Servises::timer_start();

$auth = Servises::AuthOPAC();
Servises::report($auth[code]);
if ($auth[code] === 200) $TOKEN = $auth[content]->access_token;
else return;

$SubDB = '01';
//$result_array =file("test_db_400_{$SubDB}.csv");
$result_array =file("jpg_source_{$SubDB}.csv");// имя файла для обработки  net_856.csv
$COUNT = count($result_array);
echo "Количество записей => $COUNT <br>";

$idWithProblems = array();
$item_csv = array();
$NoResource = array();
$i = 0;
foreach ($result_array as $LibId) {// цикл перебора $COUNT

echo "i=> $i;  ID => $LibId <br>";
//if ($i>50) exit;
$current_Id = new FieldLibId($TOKEN,IDB, $LibId);

if ($current_Id->httpcode >= 400) {
  $item_csv[]= log_report($LibId,HTTP_CODE_ARRAY[$current_Id->httpcode],$current_Id->httpcode,'Ошибка при считывании');
  $idWithProblems[] = $LibId;
}else{
foreach ($current_Id ->response as $fields) {
  $field = $fields[attributes][fields];
  $is856 = false;
		if (is_array($field)) {
			foreach ($field as $tags) {
				if ($tags[tag]==856) {
        $is856 = true;
			 	$subField = $tags[subfields];
			 		if (is_array($subField)) {
			 			foreach ($subField as $ip_address){
			 				if ($ip_address[code] == 'u') {
          echo "Обнаружена ссылка => ".$ip_address[data]."<br>";
      	 			if (preg_match(FILTER_JPG, $ip_address[data], $matches) == 1) {
$oldIpAddress = $ip_address[data];
$newIpAddress = preg_filter(FILTER_JPG,'.pdf', $ip_address[data]);
echo "Заменяем на PDF ссылку => $newIpAddress <br>";

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
$writeField = new SetFields($TOKEN, IDB, $LibId, $request_correction);

echo "Результат запроса замены: {$writeField ->httpcode}<br>";

if ($writeField->httpcode >= 400) { // проверка качества замены и наличие ресурса
  echo "Проблемная запись => ".$LibId."<br>";
  //echo "<pre>";print_r($request_correction);echo "</pre>";
  $item_csv_row = "-------\n".$LibId.$newIpAddress."\n Код - ".$writeField->httpcode." - "."Ошибка при корррекции записи"."\n";
  $item_csv[]= $item_csv_row;
  $idWithProblems[] = $LibId;
} else {
  $serverRequest = new GetServerResponse($newIpAddress,3);
  echo "Код проверки ссылки: {$serverRequest ->httpcode}<br>";
  echo "Ссылка: {$newIpAddress}<br>";
  if ($serverRequest ->httpcode >= 400) {// Пишем содержимое в файл
    $NoResource[]= log_report($LibId,$newIpAddress,$serverRequest ->error,"Ошибка существования ресурса");
    $idWithProblems[] = $LibId;
  }
} // проверка качества замены и наличие ресурса
}else{ //если не нашли jpg проверить на pdf
$serverRequest = new getServerResponse($ip_address[data],3);
  echo "Код проверки ссылки: {$serverRequest ->httpcode}<br>";
  echo "Ссылка: {$ip_address[data]}<br>";
  if ($serverRequest ->httpcode >= 400) {// Пишем содержимое в файл
   $NoResource[] = log_report($LibId, $ip_address[data], $serverRequest ->error, "Ошибка существования ресурса");
    $idWithProblems[] = $LibId;
  }
}
}
}
}
}//tag 856
}
}
}
if (!$is856){
    echo "Нет 856 поля<br>";
    $NoResource_row = "-------\n".$LibId."Нет 856 поля\n";
    $NoResource[]= $NoResource_row;
    $idWithProblems[] = $LibId;
};
}

$i++;
} // цикл перебора $COUNT

//echo "<pre>";print_r($idWithProblems);echo "</pre>";
echo 'count of records $idWithProblems = '.count($idWithProblems).'<br>';

$time = date("dmYHi");
$STATISTIC_CSV = "ProblemsCorrection_{$SubDB}_{$time}.csv";
file_put_contents($STATISTIC_CSV, $item_csv, LOCK_EX);
$STATISTIC_CSV = "NoResource_{$SubDB}_{$time}.csv";
file_put_contents($STATISTIC_CSV, $NoResource, LOCK_EX);

echo Servises::timer_finish() . ' сек.';
?>
