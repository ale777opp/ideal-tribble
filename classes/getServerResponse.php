<?php
Class GetServerResponse{

function __construct($url,$timeout)
{
	$this ->timeout = $timeout;
	$this ->url = $url;
	$this ->url = parse_url($this ->url);
	$this ->arr = explode('/', $this ->url['path']);
	$this ->coded = array_map('urlencode', $this ->arr);
	$this ->restored = 'http://'.$this ->url['host'].implode('/', $this ->coded);
$ch = curl_init($this ->restored);
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$this ->timeout);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch,CURLOPT_HEADER,true);
curl_setopt($ch,CURLOPT_NOBODY,true);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
$this ->response = json_decode(curl_exec($ch),true);
//echo "<pre>";print_r(curl_getinfo($ch));echo "</pre><br>";
$this ->httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
$this ->errno = curl_errno($ch);
$this ->class_name = get_class();
curl_close($ch);
return Servises::ErrorCodeHandler($this ->class_name,$this ->httpcode,$this ->errno);
} //---END OF CONSTRUCT
} //---END OF CLASS
?>