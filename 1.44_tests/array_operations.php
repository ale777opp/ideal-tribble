<?php
$result_array = array();
//for ($i=1;$i<=15;$i++){
$array_1 = array();
$array_2 = array();
/*
$file_name ='jpg_source250620211533.csv';// имя файла для обработки
echo "file name $file_name <br>";
$intermediate_array=file($file_name);
$result_array = array_merge($result_array, $intermediate_array);

$intermediate_array = array();
$file_name ='jpg_source250620211309.csv';// имя файла для обработки
echo "file name $file_name <br>";
$intermediate_array=file($file_name);
$result_array = array_merge($result_array, $intermediate_array);

$intermediate_array = array();
$file_name ='jpg_source280620211103.csv';// имя файла для обработки
echo "file name $file_name <br>";
$intermediate_array=file($file_name);
$result_array = array_merge($result_array, $intermediate_array);
*/
$file_1 ='test_db_400_unique300620211725.csv';// имя файла для обработки
$file_2 ='jpg_source_unique280620211736.csv';// имя файла для обработки

echo "file_1 $file_1 <br>";
echo "file_2 $file_2 <br>";

$array_1 = file($file_1);
$array_2 = file($file_2);

echo "Всего элементов в 1: ".count($array_1)."<br>";
echo "Всего элементов в 2: ".count($array_2)."<br>";

$result_array = array_diff($array_1,$array_2);

$test = date("dmYHi");//"test"
$STATISTIC_CSV = "compar_jpg_source".$test.".csv";
file_put_contents($STATISTIC_CSV,$result_array,LOCK_EX);

//}
echo "Всего элементов: ".count($result_array)."<br>";

//echo "Всего уникальных элементов: ".count($result_array)."<br>";
//echo "Дельта: ".(count($intermediate_array)-count($result_array))."<br>";
?>