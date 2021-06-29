<?php
require_once("grant.php");
require_once("config.php");
spl_autoload_register(function($class){
    require_once 'classes/' . $class . '.php';
});
Servises::timer_start();
set_time_limit(0);
$pattern = '/\.jpg$/i';
$auth = new AuthOPAC();
Servises::report($auth->httpcode);
if ($auth->httpcode === 200){ //запрос при успешной авторизации
	$TOKEN = $auth->result->access_token;
}

$result_array =file("test_db_400_all.csv");
$COUNT = count($result_array);
echo "Количество записей => $COUNT <br>";

$LIMIT  = 1000; //950;

$test = date("dmYHi");//"test"
$STATISTIC_CSV = "jpg_source".$test.".csv";

for ($i = 207000;$i<=$COUNT;$i=$i+$LIMIT) {// цикл перебора $COUNT
echo "Start Position is : $i <br>";
$idWithJPG[] ='';
for ($j = 0;$j<$LIMIT;$j++){
	$k = $i+$j;
	echo "i=>".$i."  j=>".$j."<br>";
	$LibId = $result_array[$k];
	if (!empty($LibId)){
		echo "libid $LibId <br>";
	$current_Id = new FieldLibId($TOKEN,IDB, $LibId);
  	Servises::report($current_Id->httpcode);
		foreach ($current_Id ->response as $fields) {
		$field = $fields[attributes][fields];
		//echo "<pre>libid";print_r($field);echo "</pre><br>";
			if (is_array($field)) {
			foreach ($field as $tags) {
				if ($tags[tag]==856) {
			 	$subField = $tags[subfields];
			 		if (is_array($subField)) {
			 			foreach ($subField as $ip_address){
			 				if ($ip_address[code] == 'u') {
			 				if (preg_match( $pattern, $ip_address[data], $matches) == 1) {
								$idWithJPG[] = $LibId;
							}
							}
						}
					}
				}
			}
			}
		}
	}
}
echo 'count of records $idWithJPG = '.count($idWithJPG).'<br>';
file_put_contents($STATISTIC_CSV, $idWithJPG);

} // цикл перебора $COUNT



echo Servises::timer_finish() . ' сек.';
?>
