<?php
if($_POST) file_put_contents('test.txt', json_encode($_POST));

if(!$_POST) echo "it works";
?>