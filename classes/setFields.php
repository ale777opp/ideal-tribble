<?php
Class SetFields{

function __construct($token, $dbId, $libid,$data_string)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	$this ->libid = $libid;
  	$this ->libid = trim($this ->libid);
  	$this ->libid = urlencode($this ->libid);

$this ->request= URL_API.REQUEST_DB."/".$this ->dbId."/records/".$this ->libid;
//var_dump($this ->request);

$ch = curl_init($this ->request);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(REQUEST_CONTENT_JSON,RESPONSE_CONTENT_JSON,'authorization: Bearer '.$this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$this ->response = json_decode(curl_exec($ch),true);
//var_dump($this ->httpcode);
$this ->httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
//var_dump($this ->httpcode);
$this ->errno = curl_errno($ch);
//var_dump($this ->errno);
$this ->class_name = get_class();
//var_dump($this ->class_name);

curl_close($ch); // закрываем CURL
return Servises::ErrorCodeHandler($this ->class_name,$this ->httpcode,$this ->errno);
} //---END OF CONSTRUCT
} //---END OF CLASS
?>