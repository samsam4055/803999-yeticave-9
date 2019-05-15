<?php
$is_auth = 0;
$user_name = '';
session_start();

if(isset($_SESSION['user'])) {
    $user_name = $_SESSION['user']['name'];
    $is_auth = 1;
} else {
  $is_auth = 0;
  $user_name = '';
}

date_default_timezone_set("Europe/Moscow");
setlocale(LC_ALL, 'ru_RU');

define('MAX_LOT_NAME_LENGTH', '128');
define('MAX_LOT_DESC_LENGTH', '512');
define('MAX_USER_NAME_LENGTH', '64');
define('MAX_USER_CONTACT_LENGTH', '128');

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
