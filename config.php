<?php
//const TODAY = date("d.m.Y");//'28.02.2021';date("d.m.Y");
const FILTER_DATE = '/([0-3]\d)(-|\/|\.|\\\)([0,1]\d)\2(20[0-2]\d)/';
const FILTER_JPG = '/(\.jpg$)|(\.png$)/i';
const IDB = '400';
const URL_API = 'http://192.168.1.214/api/v1';
const REQUEST_AUTH = '/oauth2/token';
const REQUEST_DB = '/databases';
const REQUEST_REC = '/records?filter[query]=';
const REQUEST_CONTENT_URL = 'Content-Type: application/x-www-form-urlencoded';
const REQUEST_CONTENT_JSON = 'Content-Type: application/json';
const RESPONSE_CONTENT_JSON = 'Accept: application/vnd.api+json';
//const REQUEST_CONTENT_JSON = 'Content-Type: application/vnd.api+json';

//const LINKS_NOT_CORRECT = 'log_';
//const STATISTIC_CSV = 'statistic_';

const TIMEOUT_DEFAULT = 3;
const SPACE = '%20';

const LIMIT = '&limit=';
const OPTIONS = '&options[views]=';
const POSITION = '&position=';
const SP = '%2C';
const SHOTFORM = 'SHOTFORM';
const LINEORD = 'LINEORD';

const HTTP_CODE_ARRAY = ["100" =>"Продоложить (Continue)",
                    "101" =>"Переключение протоколов (Switching Protocols)",
                    "102" =>"Идёт обработка (Processing)",
                    "103" =>"Ранняя метаинформация (Early Hints)",
                    "200" =>"OK",
                    "201" =>"Создано (Created)",
                    "202" =>"Принято (Accepted)",
                    "203" =>"Информация не авторитетна (Non-Authoritative Information)",
                    "204" =>"Нет содержимого (No Content)",
                    "205" =>"Сбросить содержимое (Reset Content)",
                    "206" =>"Частичное содержимое (Partial Content)",
                    "207" =>"Многостатусный (Multi-Status)",
                    "208" =>"Уже сообщалось (Already Reported)",
                    "226" =>"Использовано IM (IM Used)",
                    "300" =>"Множество выборов (Multiple Choices)",
                    "301" =>"Перемещено навсегда (Moved Permanently)",
                    "302" =>"Перемещено временно (Moved Temporarily)",
                    "303" =>"Смотреть другое (See Other)",
                    "304" =>"Не изменялось (Not Modified)",
                    "305" =>"Использовать прокси (Use Proxy)",
                    "306" =>" — зарезервировано (код использовался только в ранних спецификациях)",
                    "307" =>"Временное перенаправление (Temporary Redirect)",
                    "308" =>"Постоянное перенаправление (Permanent Redirect)",

                    "400" =>"Неправильный, некорректный запрос (Bad Request)",
                    "401" =>"Не авторизован (не представился) (Unauthorized)",
                    "402" =>"Необходима оплата (Payment Required)",
                    "403" =>"Запрещено (не уполномочен) (Forbidden)",
                    "404" =>"Не найдено (Not Found)",
                    "405" =>"Метод не поддерживается (Method Not Allowed)",
                    "406" =>"Неприемлемо (Not Acceptable)",
                    "407" =>"Необходима аутентификация прокси (Proxy Authentication Required)",
                    "408" =>"Истекло время ожидания (Request Time-out)",
                    "409" =>"Конфликт (Conflict)",
                    "410" =>"Удалён (Gone)",
                    "411" =>"Необходима длина (Length Required)",
                    "412" =>"Условие ложно (Precondition Failed)",
                    "413" =>"Полезная нагрузка слишком велика (Request Entity Too Large)",
                    "414" =>"URI слишком длинный (Request-URI Too Large)",
                    "415" =>"Неподдерживаемый тип данных (Unsupported Media Type)",
                    "416" =>"Диапазон не достижим (Range Not Satisfiable)",
                    "417" =>"Ожидание не удалось (Expectation Failed)",
                    "418" =>"«Я — чайник» (I’m a teapot)",
                    "419" =>"Обычно ошибка проверки CSRF (Authentication Timeout (not in RFC 2616)",
                    "421" =>"Misdirected Request",
                    "422" =>"Необрабатываемый экземпляр (Unprocessable Entity)",
                    "423" =>"Заблокировано (Locked)",
                    "424" =>"Невыполненная зависимость (Failed Dependency)",
                    "425" =>"Слишком рано (Too Early)",
                    "426" =>"Необходимо обновление (Apgrade Required)",
                    "428" =>"Необходимо предусловие (Precondition Required)",
                    "429" =>"Слишком много запросов (Too Many Requests)",
                    "431" =>"Поля заголовка запроса слишком большие (Request Header Fields Too Large)",
                    "449" =>"Повторить с ... (Retry With)»",
                    "451" =>"Недоступно по юридическим причинам (Unavailable For Legal Reasons)",
                    "500" =>"Внутренняя ошибка сервера (Internal Server Error)",
                    "501" =>"Не реализовано (Not Implemented)",
                    "502" =>"Плохой, ошибочный шлюз (Bad Gateway)",
                    "503" =>"Сервис недоступен (Service Unavailable)",
                    "504" =>"Шлюз не отвечает (Gateway Time-out)",
                    "505" =>"Версия HTTP не поддерживается (HTTP Version not supported)",
                    "506" =>"Вариант тоже проводит согласование (Variant Also Negotiates)",
                    "507" =>"Переполнение хранилища (Insufficient Storage)",
                    "508" =>"Обнаружено бесконечное перенаправление (Loop Detected)",
                    "509" =>"Исчерпана пропускная ширина канала (Bandwidth Limit Exceeded)",
                    "510" =>"Не расширено (Not Extended)",
                    "511" =>"Требуется сетевая аутентификация (Network Authentication Required)",
                    "520" =>"Неизвестная ошибка (Unknown Error)",
                    "521" =>"Веб-сервер не раотает (Web Server Is Down)",
                    "522" =>"Соединение не отвечает (Connection Timed Out)",
                    "523" =>"Источник недоступен (Origin Is Unreachable)",
                    "524" =>"Время ожидания истекло (A Timeout Occurred)",
                    "525" =>"Квитирование SSL не удаось (SSL Handshake Failed)",
                    "526" =>"Недействительный сертификатSSL (Invalid SSL Certificate)",
                    "noValue"=>"Неизвестный код состояния (Unknown status code)",
];
?>