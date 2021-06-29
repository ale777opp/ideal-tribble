<?php
Class RequestArrayProcessing{
	protected $token;
	protected $dbId;
	protected $fld;
	protected $query;
	protected $limit;
function __construct($token, $dbId, $query,$limit,$position)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	//$this ->fld = $fld;
	$this ->limit = $limit;
	$this ->position = $position;
	$this ->query =urlencode($query);
	$request = URL_API.REQUEST_DB."/".$this ->dbId.REQUEST_REC.$this ->query.LIMIT.$this ->limit.POSITION.$this ->position.OPTIONS.LINEORD; //$this ->fld.SPACE.;

echo "request $request <br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(RESPONSE_CONTENT_JSON, 'authorization: Bearer ' . $this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$this ->result = json_decode(curl_exec($ch), true);

//echo "<pre>";print_r($this ->result);echo "</pre>";

$this ->count = $this ->result[meta];//['count']
//echo "<pre>";print_r($this ->count);echo "</pre>";
$this ->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
return;
}

}
?>