<?php
$is_auth = rand(0, 1);
$user_name = 'Andrii Smerechynskyi';

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

define('MAX_NAME_LENGTH', '128'); 
define('MAX_DESC_LENGTH', '512'); 

$db = [
  "host" => "localhost",
  "user" => "root",
  "password" => "",
  "database" => "yeticave",
];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

if (!$link) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

if (!mysqli_set_charset($link, "utf8")) {
    die("Ошибка подключения: " . mysqli_error($link));
}
