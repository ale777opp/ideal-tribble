<?php
require_once("grant.php");
require_once("config.php");
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
Servises::timer_start();

$auth = new AuthOPAC();
Servises::report($auth->httpcode);
if ($auth->httpcode === 200){
	$TOKEN = $auth->result->access_token;
}
$COUNT = 453879;
$FLD = 'ID';
$QUERY = '*';
$LIMIT  = 950; //950;
$POSITION = 0; // 453150; $start_position

print_r('idb = '.IDB.'<br>');
print_r("fld = $FLD <br>");
print_r("query = $QUERY <br>");
print_r("limit = $LIMIT <br>");
print_r("position = $POSITION <br>");
$pattern = '/\.jpg$/i';
$item_csv[] ='';
$test = date("dmYHi");//"test"
$STATISTIC_CSV = "test_db_400".$test.".csv";

for ($i = 0;$i<=$COUNT/$LIMIT;$i++) {// цикл перебора
$POSITION = $i* $LIMIT;
$processing = new RequestArrayProcessing($TOKEN,IDB,$FLD,$QUERY,$LIMIT,$POSITION);
//Servises::report($processing->httpcode);
	if ($processing ->httpcode === 200){

$data = $processing ->result[data];
foreach ($data as $item){
	$result_array[] = $item[id]."\n";
}
} //обработка 200 кода авторизации
else {
	echo 'Ошибка. '; //get_called_class(),
	print_r($processing ->code.'  =>  '.HTTP_CODE_ARRAY[$processing ->code].'<br>');
	return false;
}
echo "The number of iteration is : $i <br>";
echo "Start Position is : $POSITION <br>";
file_put_contents($STATISTIC_CSV, $result_array);//LOCK_EX

} // цикл перебора

//echo "<pre>";print_r($result_array);echo "</pre>";
echo 'count of records = '.count($result_array).'<br>';
echo 'count of unique records = '.count(array_unique($result_array)).'<br>';

//echo "<pre>";print_r($idWhith856);echo "</pre>";
echo 'count of records $idWhith856 = '.count($idWhith856).'<br>';

echo Servises::timer_finish() . ' сек.';
?>
