<?php

$IDB = '425';
$TODAY = '28.02.2021';//'28.02.2021';
$FILTER_DATE = '/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/';

$URL_API = 'http://192.168.1.44/api/v1';
$REG_AUTH = '/oauth2/token';
$REG_DB = '/databases';
$REG_REC = '/records?filter[query]=';
$SPACE = "%20";

//$LIBID = 'RSLA%255CBIBL%255C0000214413';
$LIBID = 'RSLA%255CBIBL%255C0000474018';

$REG_CONT_URL = 'Content-Type: application/x-www-form-urlencoded';
$REG_CONT_JSON = 'Content-Type: application/json';
$RESP_CONT_JSON	= 'Accept: application/vnd.api+json';
?>