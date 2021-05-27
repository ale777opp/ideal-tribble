<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
Timer::start();

require('config.php');

$COUNT = 13728;
$FLD = 'ID';
$QUERY = '(ID *) AND (IZO1 HTTP://195.178.222.75:8083/PICS/CARD/RGBI_05*)';
$LIMIT  = 500;
$POSITION = 0; // 453150; $start_position

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');
print_r('limit = '.$LIMIT.'<br>');
print_r("position = $POSITION <br>");

['code' => $httpcode, 'content' => $auth] = authOPAC();
if ($httpcode === 200) {
$Token = $auth->access_token;
$QUERY = urlencode($QUERY);
$QUERY = $QUERY.LIMIT.$LIMIT.OPTIONS.LINEORD.POSITION.$POSITION;
//----------------------------------------------------
for ($i = 0;$i<=$COUNT/$LIMIT;$i++) {
$POSITION = $i* $LIMIT;
	//----------------------------
$QUERY = substr_replace($QUERY, $POSITION, 132);

// echo "Начало => $POSITION <br>";
//$QUERY = $QUERY.POSITION.$POSITION;
//echo "Запрос => $QUERY <br>";
['code' => $httpcode, 'content' =>$record] = searchQuery($Token,$IDB,$FLD,$QUERY);
if ($httpcode === 200) {
	foreach ($record['data'] as $data){
		$result_array[] = $data['id'];
	}
}
	//----------------------------
echo "The number of iteration is : $i <br>";
echo "Start Position is : $POSITION <br>";
}
//--------------------------------------------------
echo "<pre>";print_r(count($result_array));echo "</pre>";
//echo "<pre>";print_r($result_array);echo "</pre>";
}

?>
