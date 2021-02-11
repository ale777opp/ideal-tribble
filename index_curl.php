<?php
  $URL = 'http://www.google.com';

  if(isAvailible($URL)){
    echo 'Сайт доступен.';
  }else{
    echo 'Сайт недоступен.';
  }
function isAvailible($url) {
	echo 'url = '.filter_var($url, FILTER_VALIDATE_URL).'<br>';
    // Проверка правильности URL
    if(!filter_var($url, FILTER_VALIDATE_URL)){
 echo "Ошибка.".'<br>';
      return false;
    }

    // Инициализация cURL
    $curlInit = curl_init($url);

    // Установка параметров запроса
    curl_setopt($curlInit,CURLOPT_CONNECTTIMEOUT,10);
    curl_setopt($curlInit,CURLOPT_HEADER,true);
    curl_setopt($curlInit,CURLOPT_NOBODY,true);
    curl_setopt($curlInit,CURLOPT_RETURNTRANSFER,true);

    // Получение ответа
    $response = curl_exec($curlInit);
    $http_code = curl_getinfo($curlInit, CURLINFO_HTTP_CODE);
    echo " http_code $http_code <br>";
    // закрываем CURL
    curl_close($curlInit);
echo '<pre>';
print_r($response);
echo '</pre>';
    return $response ? true : false;
}

print_r(get_headers($URL, 1));

?>
