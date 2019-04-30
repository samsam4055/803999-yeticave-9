<?php
$is_auth = rand(0, 1);
$user_name = 'Andrii Smerechynskyi';
$title = 'Главная';

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

$db = [
  "host" => "localhost",
  "user" => "root",
  "password" => "",
  "database" => "yeticave",
];

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);

if (!$link) {
    print("Ошибка подключения: " . mysqli_connect_error());
    die();
}

mysqli_set_charset($link, "utf8");
