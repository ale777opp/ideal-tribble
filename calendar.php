<?php

error_reporting(0);

if(isset($_POST['search'])) {
    searchOPAC($_POST['idb'], $_POST['fld'], urlencode($_POST['query']));
}

function searchOPAC($idb, $fld, $query = ''){

    if (empty($query)) {
        return false;
    }

    $ch = curl_init();

    $request = [
        'grant_type' => 'password',
        'client_id' => '354FE540-6100-436F-A212-7B29C4D09545',
        'client_secret' => 'rhBQCWiIufQRooTtXcH',
        'username' => 'PRGUS',
        'password' => 'wsDCrf7',
        'scope' => 'read',
    ];

    curl_setopt($ch, CURLOPT_URL, "http://opac.liart.ru/api/v1/oauth2/token");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded', 'Accept: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $auth = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $auth = json_decode(curl_exec($ch));
    $httpcode = curl_getinfo($ch, CURLINFO_RESPONSE_CODE);

    if ($httpcode === 200) {
        $record = searchquery($auth->access_token, $idb, $fld, $query);
        if ($record) {
            echo "<pre>";
            print_r($record['data']);
            echo "</pre>";
        } else {
            return false;
        }
    }
}

function searchquery($token, $dbId, $fld, $query) {

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://opac.liart.ru/api/v1/databases/" . $dbId . "/records?filter[query]=". $fld ."%20" . $query);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept: application/vnd.api+json', 'authorization: Bearer ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $search = json_decode(curl_exec($ch), true);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if ($httpcode == 200) {
        if ( $search['meta']['count'] > 0 ) {
            return $search;
        } else {
            return false;
        }
    }

    return false;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Календарь</title>
        <style media="screen">
            .search {
                position: absolute;
                left: 50%;
                transform: translate(-50%, 0%);
            }
            .search input[type='text'] {
                width: 800px;
                height: 25px;
            }
        </style>
    </head>
    <body>
        <div class="search">
            <form method="post">
                <select name="idb">
                    <option selected value="700">КЗД</option>
                </select>
                <select name="fld">
                    <option selected value="DATA">Все даты</option>
                    <option value="ADB">Первая дата</option>
                    <option value="ADE">Вторая дата</option>
                </select>
                <input type="text" name="query" value="">
                <input type="submit" name="search" value="Поиск">
            </form>
        </div>
    </body>
</html>
