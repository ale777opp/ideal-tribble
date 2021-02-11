<?php
 
    $domain = 'http://google.ru';
 
    if(preg_match('/[^0-9a-z-_A-Z:\/\.]/is', $domain)!=0){
 
        include("idna_convert.class.php");
 
        $IDN = new idna_convert(array('idn_version' => '2008'));
 
        $domain=$IDN->encode($domain);
 
    }
 
    $status=get_headers($domain);
 
    if(in_array("HTTP/1.1 200 OK", $status) or in_array("HTTP/1.0 200 OK", $status)){
 
        echo $domain.' - доступен';
 
    }
 
?>