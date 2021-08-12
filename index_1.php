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

$COUNT = 483819;
$SubDB = '01';
$QUERY = '(ID *) AND (IZO1 HTTP://195.178.222.75:8083/PICS/CARD/RGBI_'.$SubDB.'*)';
$LIMIT  = 500; //ограничение в настройках OPAC-Global
$POSITION = 0; //start_position

print_r('idb = '.IDB.'<br>');
print_r("SubDB = $SubDB <br>");
print_r("query = $QUERY <br>");
print_r("limit = $LIMIT <br>");
print_r("position = $POSITION <br>");

$item_csv[] ='';
$time = date("dmYHi");//"test"
$STATISTIC_CSV = "test_db_400_{$SubDB}_{$time}.csv";

while($POSITION<$COUNT){
$processing = new RequestArrayProcessing($TOKEN,IDB,$QUERY,$LIMIT,$POSITION);
<<<<<<< HEAD
$COUNT = $processing ->response[meta][count];
//echo "<pre>записей =>  ";print_r($processing ->response[meta][count]);echo "</pre>";
$data = $processing ->response['data'];
foreach ($data as $item) $result_array[] = $item[id]."\n";
=======
//Servises::report($processing->httpcode);
if ($processing ->httpcode === 200){
echo "<pre>";print_r($processing ->count[count]);echo "</pre><br>";
$data = $processing ->result['data'];
	foreach ($data as $item){
		$result_array[] = $item[id]."\n";
	}
	}else { //обработка 200 кода авторизации
	echo 'Ошибка. '; //get_called_class(),
	print_r($processing ->code.'  =>  '.HTTP_CODE_ARRAY[$processing ->code].'<br>');
	//return false;
	}
echo "The number of iteration is : $i <br>";
echo "Start Position is : $POSITION <br>";
file_put_contents($STATISTIC_CSV, $result_array);//,LOCK_EX
>>>>>>> 5983a35ed369cb62ac7b4ca4e677d94e8ca1023c

file_put_contents($STATISTIC_CSV, $result_array);//,LOCK_EX
$POSITION+=$LIMIT;
}//окончание итерации

//echo "<pre>";print_r($result_array);echo "</pre>";
echo 'count of records = '.count($result_array).'<br>';
echo 'count of unique records = '.count(array_unique($result_array)).'<br>';
echo Servises::timer_finish() . ' сек.';
?>
