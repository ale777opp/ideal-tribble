<?php
Class FieldLibId{

function __construct($token, $dbId, $libid)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	$this ->libid= urlencode(trim($libid));
	$this ->request = URL_API.REQUEST_DB."/".$this ->dbId."/records/".$this ->libid;

$ch = curl_init($this ->request);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(RESPONSE_CONTENT_JSON, 'authorization: Bearer ' . $this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$this ->response = json_decode(curl_exec($ch), true);
$this ->httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$this ->errno = curl_errno($ch);
$this ->class_name = get_class();
curl_close($ch); // закрываем CURL
//echo "<pre>";print_r($this ->httpcode);echo "</pre>";
return Servises::ErrorCodeHandler($this ->class_name,$this ->httpcode,$this ->errno);
}//  ---END OF CONSTRUCT
}//  ---END OF CLASS
?>