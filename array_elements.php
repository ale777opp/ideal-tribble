<?php
$result_array = array();
for ($i=1;$i<=15;$i++){
$intermediate_array = array();
$file_name ='jpg_source_'.$i.'.csv';// имя файла для обработки
echo "file name $file_name <br>";
$intermediate_array=file($file_name);
$result_array = array_merge($result_array, $intermediate_array);
}
echo "Всего элементов: ".count($result_array)."<br>";
echo "Всего уникальных элементов: ".count(array_unique($result_array))."<br>";
echo "Дельта: ".(count($result_array)-count(array_unique($result_array)))."<br>";
?>