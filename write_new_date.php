<?php
error_reporting(E_ALL);

$today = date("d.m.Y");
$yesterday = mktime(0, 0, 0,  date("d")-1, date("m")  ,date("y"));;
$tomorrow  = mktime(0, 0, 0,  date("d")+1, date("m")  ,date("y"));
echo " $today <br>";
echo " $yesterday <br>";
echo " $tomorrow <br>";
echo "<br>";

$field_300  = ' Дата обращения к ресурсу 02\12\2013 ';
/*
$result = preg_match_all('/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/',$field_300,$out, PREG_OFFSET_CAPTURE);
if ($result){ print_r($out[0][0][0]);}
*/
$result = preg_filter('/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/',$today,$field_300);
if ($result){print_r($result.'<br>');}

//$value = 'http://www.art.nnov.ru/archoteca/index.php';
$value = 'https://izo-museum.ru/upload/files/2%20rus%20avangard.pdf';

//foreach ($response['http'] as $value)
			//^(http|https) #^([fh]tt?ps?) http[s]?
$val = preg_match('/http[s]?:\/\/(?:[-\w]+\.)?([-\w]+)\.\w+(?:\.\w+)?\/?/',$value, $matches, PREG_OFFSET_CAPTURE);
echo "<pre>";print_r($matches);echo "</pre>";


?>