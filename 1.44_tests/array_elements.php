<?php
$result_array = array();
//for ($i=1;$i<=15;$i++){
$intermediate_array = array();
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
$file_name ='test_db_400_summ_23062021.csv';// имя файла для обработки
echo "file name $file_name <br>";
$intermediate_array=file($file_name);
$result_array = array_unique($intermediate_array);


$test = date("dmYHi");//"test"
$STATISTIC_CSV = "test_db_400_unique".$test.".csv";
file_put_contents($STATISTIC_CSV,$result_array,LOCK_EX);

//}
echo "Всего элементов: ".count($intermediate_array)."<br>";
echo "Всего уникальных элементов: ".count($result_array)."<br>";
echo "Дельта: ".(count($intermediate_array)-count($result_array))."<br>";
?>