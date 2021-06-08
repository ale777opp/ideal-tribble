<?php
class Servises{
private static $start = .0;
private static $error = '';
    static function timer_start()
    {
        self::$start = microtime(true);
    }
    static function timer_finish()
    {
        return microtime(true) - self::$start;
    }

    static function report($code){
	if ($code != 200) {echo 'Код ответа на запрос '.__CLASS__.' = '; //get_parent_class($this)
	//else echo 'Ошибка. '; //get_called_class(),
   	print_r($code.'  =>  '.HTTP_CODE_ARRAY[$code].'<br>');
    //echo "<pre>";print_r(debug_backtrace());echo "</pre>";
    }
	}

    static function isJSON($string){
    self::$error = is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE);
    self::$error? false : true ;
    if (!self::$error) print_r('JSON errors =>'.json_last_error_msg().'<br>');
    return;
    }

static function ErrorCodeHendler($class_name,$httpcode,$errno)
{
if ($errno){
    $error = ' cURL '.curl_strerror($errno);
    echo "Ошибка $class_name ({$errno}):\n {$error} <br>";
    return;
}else{
if ($httpcode >= 400) {
    $error = HTTP_CODE_ARRAY[$httpcode];
    $errno = $httpcode;
    echo "Ошибка $class_name ({$errno}):\n {$error} <br>";
    return;
    }
}
return;
}
}
?>