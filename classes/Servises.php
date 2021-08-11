<?php
class Servises{
private static $start = .0;
private static $error = '';
private static $request = '';
private static $result = '';
private static $httpcode = '';
    static function timer_start()
    {
        self::$start = microtime(true);
    }
    static function timer_finish()
    {
        return microtime(true) - self::$start;
    }
    static function AuthOPAC(){
    self::$request = [
        'grant_type' => GRANT_TYPE,
        'client_id' => CLIENT_ID,
        'client_secret' => CLIENT_SECRET,
        'username' => USERNAME,
        'password' => PASSWORD,
        'scope' => SCOPE,
    ];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,URL_API.REQUEST_AUTH);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(self::$request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(REQUEST_CONTENT_URL, REQUEST_CONTENT_JSON));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    self::$result = json_decode(curl_exec($ch));
    self::$httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    curl_close($ch); // закрываем CURL
    return ['code' => self::$httpcode, 'content' => self::$result];
    }

    static function report($code){
	if ($code != 200) echo "Код ответа на запрос ".__METHOD__." = $code =>  ".HTTP_CODE_ARRAY[$code]."<br>";
    }

    static function log_report($item,$property,$code,$text){
    $row = "-------\n".$item." => ".$property."\n Код - ".$code."\n -  ".$text."\n";
    return $row;
    }

    static function isJSON($string){
    self::$error = is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
    self::$error? false : true ;
    if (!self::$error) print_r('JSON errors =>'.json_last_error_msg().'<br>');
    return;
    }

static function ErrorCodeHandler($class_name,$httpcode,$errno)
{
if ($errno){
    $error = ' cURL '.curl_strerror($errno);
    echo "Ошибка $class_name ({$errno}):\n {$error} <br>";
    return true;
}else if ($httpcode >= 400) {
    $error = HTTP_CODE_ARRAY[$httpcode];
    $errno = $httpcode;
    echo "Ошибка $class_name ({$errno}):\n {$error} <br>";
    return true;
    }
return false;
}
}
?>