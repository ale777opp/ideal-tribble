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
$result_array =file("test_db_400_{$SubDB}.csv");
$COUNT = count($result_array);
echo "Количество записей => $COUNT <br>";

<<<<<<< HEAD
$STATISTIC_CSV = "jpg_source_{$SubDB}.csv";
=======
$test = date("dmYHi");//"test"
$STATISTIC_CSV = "jpg_source".$test.".csv";
>>>>>>> 5983a35ed369cb62ac7b4ca4e677d94e8ca1023c
$i = 0;
$idWithJPG[] ='';

foreach ($result_array as $LibId) {// цикл перебора $COUNT
echo "Current №: $i LibId : $LibId<br>";
//if ($i>100) break;
if (!empty($LibId)){
	$current_Id = new FieldLibId($TOKEN,IDB, $LibId);
<<<<<<< HEAD
  	foreach ($current_Id ->response as $fields) {
=======
  	Servises::report($current_Id->httpcode);
	foreach ($current_Id ->response as $fields) {
>>>>>>> 5983a35ed369cb62ac7b4ca4e677d94e8ca1023c
		$field = $fields[attributes][fields];
		//echo "<pre>libid";print_r($field);echo "</pre><br>";
		if (is_array($field)) {
			foreach ($field as $tags) {
			if ($tags[tag]==856) {
			 	$subField = $tags[subfields];
			 	if (is_array($subField)) {
			 		foreach ($subField as $ip_address){
			 			if ($ip_address[code] == 'u') {
<<<<<<< HEAD
			 			if (preg_match( FILTER_JPG, $ip_address[data], $matches)== 1) {
=======
			 			if (preg_match( $pattern, $ip_address[data], $matches)== 1) {
>>>>>>> 5983a35ed369cb62ac7b4ca4e677d94e8ca1023c
							$idWithJPG[] = $LibId;
							echo "Адрес ресурса $LibId <br>";
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

echo 'count of records $idWithJPG = '.count($idWithJPG).'<br>';
file_put_contents($STATISTIC_CSV, $idWithJPG,LOCK_EX);

echo Servises::timer_finish() . ' сек.';
?>
