<?php

error_reporting(0);

if(isset($_POST['search'])) {

print_r('POST[idb] = '.$_POST['idb'].'<br>');
print_r('POST[fld] = '.$_POST['fld'].'<br>');
print_r('POST[query] = '.$_POST['query'].'<br>');

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

    print_r('Код авторизации = '.$httpcode.'<br>');
/*
    echo "<pre>";
    print_r($auth);
    echo "</pre>";
*/
    if ($httpcode === 200) {
        $record = searchquery($auth->access_token, $idb, $fld, $query);
        if ($record) {
            foreach ($record['data'] as $list) {
                foreach ($list as $l) {
                    echo "$l[leader]";
                    foreach ($l['fields'] as $field) {
                         echo "$field[tag] $field[data] $filed[ind1] $field[ind2] ";
                        if (count($field['subfields']) > 0 ) {
                            foreach ($field['subfields'] as $f) {
                                echo "$f[code] $f[data]";
                            }
                        }
                        echo "<br>";
                    }
                }
            }
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

    print_r('Код запроса = '.$httpcode.'<br>');

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
        <title>Поиск в базах данных OPAC</title>
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
                    <option value="307">Поиск по всем базам данных РГБИ</option>
                    <option value="428">Электронный абонемент</option>
                    <option selected value="300">Электронный каталог РГБИ</option>
                    <option value="304">Периодические издания</option>
                    <option value="302">Драматургия</option>
                    <option value="301">Статьи из журналов и сборников</option>
                    <option value="305">Газетные статьи</option>
                    <option value="419">Аналитическое описание микрофиш</option>
                    <option value="410">Архив справок</option>
                    <option value="425">БД Ресурсы Интернет</option>
                    <option value="17">Видеофонд</option>
                    <option value="700">КЗД</option>
                    <option value="154">ЕАФ</option>
                    <option value="21">Изобразительный материал</option>
                </select>
                <select name="fld">
                    <option selected value="FT">Все поля</option>
                    <option value="AU">Автор/(КЗД)</option>
                    <option value="CA">Коллективный автор</option>
                    <option value="TI">Заглавие</option>
                    <option value="PY">Год публикации</option>
                    <option value="PP">Место издания</option>
                    <option value="PU">Издательство</option>
                    <option value="SE">Серия</option>
                    <option value="SH">Предметные рубрики</option>
                    <option value="SB">ISBN</option>
                    <option value="SS">ISSN</option>
                    <option value="BC">ББК</option>
                    <option value="SO">Заглавие источника</option>
                    <option value="NP">Выпуск серии, номер журнала и т.д.</option>
                    <option value="IN">Инвентарный номер/Баркод</option>
                    <option value="MH">Место хранения</option>
                    <option value="AH">Везде/(КЗД)</option>
		            <option value="AC">Автор/Создатель(КЗД)</option>
                    <option value="ID">ID</option>
                </select>
                <input type="text" name="query" value="">
                <input type="submit" name="search" value="Поиск">
            </form>
        </div>
    </body>
</html>
