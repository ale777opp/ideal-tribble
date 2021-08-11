<?php
Class SetRecords{

function __construct($token, $dbId, $libid,$data_string)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	$this ->libid= urlencode(trim($libid));
	$request= URL_API.REQUEST_DB."/".$this ->dbId."/records/".$this ->libid;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(REQUEST_CONTENT_JSON,RESPONSE_CONTENT_JSON,'Content-Length: ' . strlen($data_string),'authorization: Bearer '.$this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$this ->response = json_decode(curl_exec($ch), true);
$this ->httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$this ->errno = curl_errno($ch);
$this ->class_name = get_class();
curl_close($ch); // закрываем CURL
return Servises::ErrorCodeHandler($this ->$class_name,$this ->$httpcode,$this ->$errno);
}//---END OF CONSTRUCT
} //---END OF CLASS
?>