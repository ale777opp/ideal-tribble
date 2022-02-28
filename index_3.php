<?php
require_once("grant.php");
require_once("config.php");
set_time_limit(0);
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
Servises::timer_start();
$pattern = FILTER_JPG;
$auth = Servises::AuthOPAC();
Servises::report($auth[code]);
if ($auth[code] === 200) $TOKEN = $auth[content]->access_token;
else return;

$SubDB = 'P524X';
//$result_array = [RU006217ELAR,RU01807ELART,RU204291ELAR];
$result_array =file("test_db_400_{$SubDB}.csv");
//$result_array =file("net_856.csv");//имя файла для обработки  net_856.csv
//$result_array =file("test.csv");//имя файла для обработки test.csv
$count = count($result_array);
echo "Количество записей => $count <br>";

$sourseIsJPG = array();
$idWithProblems = array();
$NoResource = array();
$logRecord = array();

$i = 0;
$offset = -3;
$length = 3;

foreach ($result_array as $LibId) {// цикл перебора $count

echo "i=> $i из $count;  ID => $LibId <br>";
//if ($i>50) exit;
$current_Id = new FieldLibId($TOKEN,IDB, $LibId);
//getFieldsLibId();
//echo "<pre>";print_r($current_Id->httpcode);echo "</pre>";
if ($current_Id->httpcode >= 400) {
  $logRecord[]= Servises::logReport($LibId,HTTP_CODE_ARRAY[$current_Id->httpcode],$current_Id->httpcode,'Ошибка при считывании LibID');
  $idWithProblems[] = $LibId;
}else{
foreach ($current_Id ->response as $fields) {
  $field = $fields[attributes][fields];
  $is856 = false;
  //echo "<pre>";print_r($field);echo "</pre>";
		if (is_array($field)) {
     // var_dump($is856);
			foreach ($field as $tags) {
        //echo "<pre>";print_r($tags);echo "</pre>";
				if ($tags[tag]==856) {
        $is856 = true;
			 	$subField = $tags[subfields];
			 		if (is_array($subField)) {
			 			foreach ($subField as $ip_address){
			 				if ($ip_address[code] == 'u') {
              echo "Обнаружена ссылка => {$ip_address[data]} <br>";


$fileЕxtension = strtolower(substr($ip_address[data], $offset,$length));
switch ($fileЕxtension) {
    case 'pdf':
        echo "расширение pdf<br>";
        $serverRequest = new GetServerResponse($ip_address[data],3);
        //echo "Проверка ссылки: {$ip_address[data]}<br>";
        echo "Код проверки ссылки: {$serverRequest ->httpcode}<br>";
        if ($serverRequest ->httpcode >= 400) {// Пишем содержимое в файл
        $logRecord[] = Servises::logReport($LibId, $ip_address[data],$serverRequest ->httpcode, "Ошибка существования ресурса");
        $NoResource[] = $LibId;
        }
        break;
    case 'jpg':
    case 'png':
        echo "расширение jpg/png<br>";

      $logRecord[] = Servises::logReport($LibId, $ip_address[data],'NULL',"Ресурс с расширением jpg/png");
      $sourseIsJPG[] = $LibId;

      $oldIpAddress = $ip_address[data];
      $newIpAddress = preg_filter(FILTER_JPG,'.pdf', $ip_address[data]);
      echo "Заменяем на PDF в ссылке => $newIpAddress <br>";
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
//echo "writeField => $writeField <br>";
if ($writeField->httpcode >= 400) { // проверка качества замены и наличие ресурса
  echo "Проблемная запись => $LibId <br>";
  //echo "<pre>";print_r($request_correction);echo "</pre>";
  $logRecord[] = Servises::logReport($LibId, $newIpAddress, $writeField->httpcode, "Ошибка при корррекции записи");
  $idWithProblems[] = $LibId;
} else {
  $serverRequest = new GetServerResponse($newIpAddress,3);
  //echo "Проверка ссылки: {$ip_address[data]}<br>";
    echo "Код проверки ссылки: {$serverRequest ->httpcode}<br>";
    if ($serverRequest ->httpcode >= 400) {// Пишем содержимое в файл
    $logRecord[] = Servises::logReport($LibId, $newIpAddress, $serverRequest ->httpcode, "Ошибка существования ресурса");
    $NoResource[] = $LibId;
}
}
        break;
    default:
        echo "расширение не определено<br>";
        break;
}
}
}
}
}
}//foreach tag 856
//echo "<pre>is856  ";print_r($is856);echo "</pre>";
//var_dump(!$is856);
if (!$is856){
    echo "Нет 856 поля<br>";
    $logRecord[] = "-------\n".$LibId."Нет 856 поля\n";
    $idWithProblems[] = $LibId;
}
}
}
}
$i++;
} // цикл перебора $count

//echo "<pre>";print_r($idWithProblems);echo "</pre>";
echo 'count of records "sourseIsJPG" =  '.count($sourseIsJPG).' <br>';
echo 'count of records "idWithProblems" = '.count($idWithProblems).'<br>';
echo 'count of records "NoResource" = '.count($NoResource).'<br>';
$time = date("dmYHi");
mkdir("log_{$time}");
$STATISTIC_CSV = "log_{$time}/sourseIsJPG_{$SubDB}.csv";
file_put_contents($STATISTIC_CSV, $sourseIsJPG, LOCK_EX);

$STATISTIC_CSV = "log_{$time}/idWithProblems_{$SubDB}.csv";
file_put_contents($STATISTIC_CSV, $idWithProblems, LOCK_EX);

$STATISTIC_CSV = "log_{$time}/NoResource_{$SubDB}.csv";
file_put_contents($STATISTIC_CSV, $NoResource, LOCK_EX);

$STATISTIC_CSV = "log_{$time}/logRecord_{$SubDB}.csv";
file_put_contents($STATISTIC_CSV, $logRecord,LOCK_EX);

echo Servises::timer_finish() . ' сек.';
?>
