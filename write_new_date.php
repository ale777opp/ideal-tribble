<?php
$today = date("d.m.y");
$yesterday = mktime(0, 0, 0,  date("d")-1, date("m")  ,date("y"));;
$tomorrow  = mktime(0, 0, 0,  date("d")+1, date("m")  ,date("y"));
echo " $today <br>";
echo " $yesterday <br>";
echo " $tomorrow <br>";
echo ($today - $yesterday);
echo "<br>";

$field_300  = ' Дата обращения к ресурсу 02\12\2013 ';

$result = preg_match_all('/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/',$field_300,$out, PREG_OFFSET_CAPTURE);
if ($result){ print_r($out[0][0][0]);}
echo "<pre>";
print_r($out);
echo "</pre>";

?>