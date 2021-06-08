<?php
Class getLibIdList{
	protected $token;
	protected $dbId;
	protected $fld;
	protected $query;
function __construct($token, $dbId, $fld, $query)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	$this ->libid = $libid;
	$this ->fld = $fld;
$idList = [];
$this ->query = urlencode($query);
$request = URL_API.REQUEST_DB."/".$this ->dbId."/indexes/".$this ->fld."?filter[query]=".$this ->query;

echo "<pre>";print_r($request);echo "</pre>";// вывод в переписке

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(RESPONSE_CONTENT_JSON,'authorization: Bearer ' .$this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = json_decode(curl_exec($ch), true);

echo "<pre>";print_r($result);echo "</pre>";

$this ->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

return;
}
}
?>