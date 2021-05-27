<?php
$string = 'http://195.178.222.75:8083/pics/Card/...6/00000154.JPGhttp://195.178.222.75:8083/pics/Card/...6/00000154.jpg';
$pattern = '/\.jpg$/i';
$subject ='';
$subject = preg_match($pattern, $string, $matches);
echo "<pre>";print_r($matches);echo "</pre>";
?>