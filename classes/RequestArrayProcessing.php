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
	$this ->limit = isset($limit)?$limit:15;
	$this ->position = isset($position)?$position:0;
	$this ->query = urlencode($query);//urlencode
	$request = URL_API.REQUEST_DB."/".$this ->dbId.REQUEST_REC.$this ->query.OPTIONS.LINEORD.LIMIT.$this ->limit.POSITION.$this ->position; //$this ->fld.SPACE.;

//echo "request $request <br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(RESPONSE_CONTENT_JSON, 'authorization: Bearer ' . $this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$this ->response = json_decode(curl_exec($ch), true);
$this ->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$this ->errno = curl_errno($ch);
$this ->class_name = get_class();
curl_close($ch);
return Servises::ErrorCodeHandler($this ->$class_name,$this ->$httpcode,$this ->$errno);
} //---END OF CONSTRUCT
} //---END OF CLASS
?>