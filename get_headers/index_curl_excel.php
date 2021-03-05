<?php
/**
 * Класс для измерения времени выполнения скрипта или операций
 */
class Timer
{
    /**
     * @var float время начала выполнения скрипта
     */
    private static $start = .0;

    /**
     * Начало выполнения
     */
    static function start()
    {
        self::$start = microtime(true);
    }

    /**
     * Разница между текущей меткой времени и меткой self::$start
     * @return float
     */
    static function finish()
    {
        return microtime(true) - self::$start;
    }
}
Timer::start();
//$start = $_SERVER['REQUEST_TIME_FLOAT'];
$src = fopen('test.csv', 'r');
while (!feof($src)) {
//for ($i=0;$i<=5;$i++){
  $line = fgets($src);
	  list($items['ID'], $items['URL'], $items['work'], $items['status']) = explode(";", $line, 4);
$URL = trim($items['URL']);
//foreach ($URLS as $URL) {

if(isAvailible($URL)){
  echo "Сайт $URL доступен.".'<br>';
}else{
  echo "Сайт $URL недоступен.".'<br>';
}

}
fclose($src);

function isAvailible($url) {
     // Проверка правильности URL
    if(!filter_var($url, FILTER_VALIDATE_URL)){
      return false;
    }
/*
echo '<pre>';
print_r(get_headers($url)[0]);
echo '</pre>';
*/
$opts = [
    'http' => [
        'timeout' => 3, // seconds
    ]
];
$context = stream_context_create($opts);
$response = get_headers($url, 1,$context)[0];


echo '<pre>';
print_r($response);
echo '</pre>';


//$file = 'log.txt';


// Пишем содержимое в файл,
// используя флаг FILE_APPEND для дописывания содержимого в конец файла
// и флаг LOCK_EX для предотвращения записи данного файла кем-нибудь другим в данное время
//file_put_contents($file, $response, FILE_APPEND | LOCK_EX);

    //$http_code = curl_getinfo($curlInit);

    //echo 'Прошло ', $http_code['total_time'], ' секунд во время запроса к ', $http_code['url'],'<br>';
    //echo 'Ответ сервера ', $http_code['http_code'], ' после запроса к ', $http_code['url'],'<br>';
    //echo " http_code $http_code ".'<br>';
    // закрываем CURL

    // вывод подробной информации

//echo '<pre>';
//print_r($response);
//echo '</pre>';
// curl_close($curlInit);
    return $response ? true : false;
  }
echo Timer::finish() . ' сек.';
/*
<?php
     if ($code !== NULL) {
                switch ($code) {
                    case 100: $text = 'Continue'; break;
                    case 101: $text = 'Switching Protocols'; break;
                    case 200: $text = 'OK'; break;
                    case 201: $text = 'Created'; break;
                    case 202: $text = 'Accepted'; break;
                    case 203: $text = 'Non-Authoritative Information'; break;
                    case 204: $text = 'No Content'; break;
                    case 205: $text = 'Reset Content'; break;
                    case 206: $text = 'Partial Content'; break;
                    case 300: $text = 'Multiple Choices'; break;
                    case 301: $text = 'Moved Permanently'; break;
                    case 302: $text = 'Moved Temporarily'; break;
                    case 303: $text = 'See Other'; break;
                    case 304: $text = 'Not Modified'; break;
                    case 305: $text = 'Use Proxy'; break;
                    case 400: $text = 'Bad Request'; break;
                    case 401: $text = 'Unauthorized'; break;
                    case 402: $text = 'Payment Required'; break;
                    case 403: $text = 'Forbidden'; break;
                    case 404: $text = 'Not Found'; break;
                    case 405: $text = 'Method Not Allowed'; break;
                    case 406: $text = 'Not Acceptable'; break;
                    case 407: $text = 'Proxy Authentication Required'; break;
                    case 408: $text = 'Request Time-out'; break;
                    case 409: $text = 'Conflict'; break;
                    case 410: $text = 'Gone'; break;
                    case 411: $text = 'Length Required'; break;
                    case 412: $text = 'Precondition Failed'; break;
                    case 413: $text = 'Request Entity Too Large'; break;
                    case 414: $text = 'Request-URI Too Large'; break;
                    case 415: $text = 'Unsupported Media Type'; break;
                    case 500: $text = 'Internal Server Error'; break;
                    case 501: $text = 'Not Implemented'; break;
                    case 502: $text = 'Bad Gateway'; break;
                    case 503: $text = 'Service Unavailable'; break;
                    case 504: $text = 'Gateway Time-out'; break;
                    case 505: $text = 'HTTP Version not supported'; break;
                    default:
                        exit('Unknown http status code "' . htmlentities($code) . '"');
                    break;
                }

                $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');

                header($protocol . ' ' . $code . ' ' . $text);

                $GLOBALS['http_response_code'] = $code;

            } else {

                $code = (isset($GLOBALS['http_response_code']) ? $GLOBALS['http_response_code'] : 200);

            }

            return $code;

        }
    }

?>
 */
 ?>

