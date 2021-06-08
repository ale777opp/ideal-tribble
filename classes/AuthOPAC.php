<?php
Class AuthOPAC{

//static $token = '';

function __construct(){

$this->request = [
    'grant_type' => GRANT_TYPE,
    'client_id' => CLIENT_ID,
    'client_secret' => CLIENT_SECRET,
    'username' => USERNAME,
    'password' => PASSWORD,
    'scope' => SCOPE,
];

$this->ch = curl_init();
curl_setopt($this->ch, CURLOPT_URL,URL_API.REQUEST_AUTH);
curl_setopt($this->ch, CURLOPT_POST, 1);
curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($this->request));
curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(REQUEST_CONTENT_URL, REQUEST_CONTENT_JSON));
curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
$this->result = json_decode(curl_exec($this->ch));
$this->httpcode = curl_getinfo($this->ch, CURLINFO_RESPONSE_CODE);

//self::$token = $this->response->access_token;
// echo "<pre>";print_r(self::$token);echo "</pre>";

curl_close($this->ch); // закрываем CURL
return;
}

}
?>