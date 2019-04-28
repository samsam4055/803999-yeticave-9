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

// $categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

$lots = [
    [
        "name" => "2014 Rossignol District Snowboard",
        "category" => "Доски и лыжи",
        "price" => "10999",
        "url" => "img/lot-1.jpg",
        "end_at" => "2019-04-20",
    ],
    [
        "name" => "DC Ply Mens 2016/2017 Snowboard",
        "category" => "Доски и лыжи",
        "price" => "159999",
        "url" => "img/lot-2.jpg",
        "end_at" => "2019-04-21"
    ],
    [
        "name" => "Крепления Union Contact Pro 2015 года размер L/XL",
        "category" => "Крепления",
        "price" => "8000",
        "url" => "img/lot-3.jpg",
        "end_at" => "2019-04-22"
    ],
    [
        "name" => "Ботинки для сноуборда DC Mutiny Charocal",
        "category" => "Ботинки",
        "price" => "10999",
        "url" => "img/lot-4.jpg",
        "end_at" => "2019-04-23",
    ],
    [
        "name" => "Куртка для сноуборда DC Mutiny Charocal",
        "category" => "Одежда",
        "price" => "7500",
        "url" => "img/lot-5.jpg",
        "end_at" => "2019-04-21",
    ],
    [
        "name" => "Маска Oakley Canopy",
        "category" => "Разное",
        "price" => "5400",
        "url" => "img/lot-6.jpg",
        "end_at" => "2019-04-22",
    ],
];
