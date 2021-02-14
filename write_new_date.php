<?php
//error_reporting(E_ALL);
/*запрос:
Request URL
https://opac-global.ru/api/v1/databases/20/records/LIBID%25255CBIBL%25255C0000000001?options[views]=SHOTFORM%2CLINEORD
https://opac-global.ru/api/v1/
databases/ - 20
records/  - LIBID%25255CBIBL%25255C0000000001
?options[views]=
SHOTFORM%2CLINEORD (поле пробел значение)
--------------
"accept: application/vnd.api+json" - добавить в cURL

запись:
Request URL
https://opac-global.ru/api/v1/databases/20/records/LIBID%25255CBIBL%25255C0000000001
"accept: application/vnd.api+json"
"Content-Type: application/vnd.api+json" - добавление в cURL
 -d "{
\"data\":[{\"op\":\"add\",
\"type\":\"marcrecord\",\"attributes\":{\"fields\":[{\"tag\":\"003\",\"data\":\"http://localhost/records/record.xml\"},
{\"tag\":\"856\",\"ind1\":\"4\",\"ind2\":\"0\",\"subfields\":[{\"code\":\"u\",\"data\":\"http://localhost/files/document.pdf\"}]}]}},
{\"op\":\"remove\",
\"type\":\"marcrecord\",\"attributes\":{\"fields\":[{\"tag\":\"003\",\"data\":\"http://localhost/records/record.xml\"}]}}]}"
*/
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

error_reporting(0);

$IDB = '425';

$FLD = 'TI';
$QUERY = 'Северные крепости';
/*
$FLD = 'ID';
$QUERY = '*';
*/
print_r('idb = '.$IDB.'<br>');
print_r('fld = '.$FLD.'<br>');
print_r('query = '.$QUERY.'<br>');

searchOPAC($IDB, $FLD, urlencode($QUERY));

function searchOPAC($idb, $fld, $query){
    $today = date("d.m.Y");
    $ch = curl_init();
    $request = [
        'grant_type' => 'password',
        'client_id' => '354FE540-6100-436F-A212-7B29C4D09545',
        'client_secret' => 'rhBQCWiIufQRooTtXcH',
        'username' => 'PRGUS',
        'password' => 'wsDCrf7',
        'scope' => 'read/write/admin',
    ];

    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $auth = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    print_r('Код запроса авторизации = '.$httpcode.'<br>');
    /*
    print_r('Токен авторизации <br>');
    echo "<pre>";
    print_r($auth);
    echo "</pre>";
    */
    if ($httpcode === 200) {
        $record = searchquery($auth->access_token, $idb, $fld, $query);
        print_r($record['data'][0]['attributes']['fields'][12]['subfields'][0]['data'].'<br>'); // 300
    /*    print_($record['data'=> ['attributes' => ['fields' => [12 =>['subfields' => [0 =>['data' => 'test']
	]
]
]
]
]
    ]);
    /*
    	print_r($record['data'][0]['attributes']['fields'][9]['subfields'][0]['data'].'<br>'); // 200
    	print_r($record['data'][0]['attributes']['fields'][29]['subfields'][0]['data'].'<br>'); // 856
	*/
/*
	echo "<pre>";
    print_r($record['data']);
    echo "</pre>";
*/

    $ch = curl_init();
    $request = array('data'=> array('attributes' => array('fields' => array([12] =>array('subfields' => array([0] =>array('data' => 'test')
	)
)
)
)
)
    );
    curl_setopt($ch, CURLOPT_URL, "http://192.168.1.44/api/v1/databases/".$IDB."/records");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));

    echo "<pre>";
    print_r($request);
    echo "</pre>";

    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $write = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    print_r('Код запроса записи = '.$httpcode.'<br>');

    }
} // --- END OF searchOPAC
function searchquery($token, $dbId, $fld, $query) {
	$request = "http://192.168.1.44/api/v1/databases/" . $dbId . "/records?filter[query]=". $fld ."%20" . $query;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $request); //
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.api+json', 'authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$search = json_decode(curl_exec($ch), true); // curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
    print_r('Запрос = '.$request.'<br>');
    print_r('Код ответа на запрос = '.$httpcode.'<br>');
/*
    echo "<pre>";
    print_r($search);
    echo "</pre>";
*/
    if ($httpcode === 200) {
        if ( $search['meta']['count'] > 0 ) {
            print_r('Количество найденных записей = '.$search['meta']['count'].'<br>');
            return $search;
        } else {
            print_r('Ошибка.<br>');
            return false;
        }
    }
} //  ---END OF searchquery
?>
