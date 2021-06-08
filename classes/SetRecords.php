<?php
Class SetRecords{

function __construct($token, $dbId, $libid,$data_string)
{
	$this ->token = $token;
	$this ->dbId = $dbId;
	$this ->libid= urlencode(trim($libid));

$request= URL_API.REQUEST_DB."/".$this ->dbId."/records/".$this ->libid;
echo "SetRecords <br>";
echo "$request <br>";
echo "$data_string <br>";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $request);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(REQUEST_CONTENT_JSON,RESPONSE_CONTENT_JSON,'Content-Length: ' . strlen($data_string),'authorization: Bearer '.$this ->token));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$this ->write = json_decode(curl_exec($ch));
$this ->httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$errno = curl_errno($ch);
$error_message = curl_strerror($errno);
echo "cURL error ({$errno}):\n {$error_message}";
echo "<pre>";print_r($this ->write);echo "</pre>";
curl_close($ch); // закрываем CURL
}
} //  ---END OF writeField