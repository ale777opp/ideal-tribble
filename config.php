<?php

$IDB = '425';
$TODAY = date("d.m.Y");//'28.02.2021';date("d.m.Y");
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

$LINKS_NOT_CORRECT = 'log.txt';

$HTTP_CODE_ARRAY = ["100" => "Continue",
                    "101" => "Switching Protocols",
                    "200" => "OK",
                    "201" => "Created",
                    "202" => "Accepted",
                    "203" => "Non-Authoritative Information",
                    "204" => "No Content",
                    "205" => "Reset Content",
                    "206" => "Partial Content",
                    "300" => "Multiple Choices",
                    "301" => "Moved Permanently",
                    "302" => "Moved Temporarily",
                    "303" => "See Other",
                    "304" => "Not Modified",
                    "305" => "Use Proxy",
                    "400" => "Bad Request",
                    "401" => "Unauthorized",
                    "402" => "Payment Required",
                    "403" => "Forbidden",
                    "404" => "Not Found",
                    "405" => "Method Not Allowed",
                    "406" => "Not Acceptable",
                    "407" => "Proxy Authentication Required",
                    "408" => "Request Time-out",
                    "409" => "Conflict",
                    "410" => "Gone",
                    "411" => "Length Required",
                    "412" => "Precondition Failed",
                    "413" => "Request Entity Too Large",
                    "414" => "Request-URI Too Large",
                    "415" => "Unsupported Media Type",
                    "500" => "Internal Server Error",
                    "501" => "Not Implemented",
                    "502" => "Bad Gateway",
                    "503" => "Service Unavailable",
                    "504" => "Gateway Time-out",
                    "505" => "HTTP Version not supported",
                   /*default:
                        exit('Unknown http status code "' . htmlentities($http_code) . '"');
                    break;
                   */
  ];
?>