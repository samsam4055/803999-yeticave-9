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
