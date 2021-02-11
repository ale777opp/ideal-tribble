<?php
$src = fopen('stat_urls_310118.csv', 'r');
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
  echo " http_code $http_code ".'<br>';
    // закрываем CURL
    curl_close($curlInit);
    // вывод подробной информации
/*
echo '<pre>';
print_r($response);
echo '</pre>';
*/
    return $response ? true : false;
  }
  ?>

