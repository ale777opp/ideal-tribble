<?php
error_reporting(E_ALL);
require_once('class.ip_adress_json.php');
Timer::start();

require('config.php');

$FLD = 'ID';
$QUERY = '*';
$LIMIT  = 941;

print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');
print_r('limit = '.$LIMIT.'<br>');

['code' => $httpcode, 'content' => $auth] = authOPAC();
if ($httpcode === 200) {
$Token = $auth->access_token;

$QUERY = urlencode($QUERY);
$QUERY = $QUERY.LIMIT.$LIMIT.OPTIONS.LINEORD;
//print_r($QUERY);

['code' => $httpcode, 'content' =>$record] = searchQuery($Token,$IDB,$FLD,$QUERY);
}

if ($httpcode === 200) {
echo "<pre>";print_r($record);echo "</pre>";
}
?>
