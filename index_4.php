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

//$$LibId = "RU203717ELAR"; // неизвестный
//$$LibId = "RU36256ELAR"; //ретроконверсия
//$$LibId = "RU203835ELAR"; // неизвестный

$LibId_array =file("ProblemCorrection.csv");// имя файла для обработки
echo "Колличество записей =>".count($LibId_array)."<br>";

$result_array = array();
$i = 0;

$row_csv[] ='';
$date = date("dmYHi");
$STATISTIC_CSV = "FullAndRetro".$date.".csv";

foreach ($LibId_array as $LibId) {// цикл перебора $COUNT
//if ($i>=10) break;
$processing = new FieldLibId($TOKEN,IDB, $LibId);
$error = Servises::ErrorCodeHandler($processing->class_name,$processing->httpcode,$processing->errno);
if (!$error){
	$level = $processing ->response['data']['meta']['level'];
	if ($level == "Retro" || $level == "Full"){
	$row_csv = "LibId =>\t".$LibId."\tУровень готовности =>\t".$level."\n";
	//$result_array[$LibId] = $level;
	$result_array[] = $row_csv;
	}
}
}// цикл перебора $COUNT
echo 'count of records = ',count($result_array),'<br>';
file_put_contents($STATISTIC_CSV,$result_array,LOCK_EX);
echo "<pre>";print_r($result_array);echo "</pre><br>";
//echo 'count of unique records = '.count(array_unique($result_array)).'<br>';
echo Servises::timer_finish() . ' сек.';
?>
