<?php
	$is_auth = rand(0, 1);
	$user_name = 'Andrii Smerechynskyi';
	$title = 'Главная';
	
	date_default_timezone_set("Europe/Moscow");
	setlocale(LC_ALL, 'ru_RU');
	$ts_midnight = strtotime('tomorrow');
	$secs_to_midnight = $ts_midnight - time();

	$hours = floor($secs_to_midnight / 3600);
	$minutes = floor(($secs_to_midnight % 3600) / 60);
	$lot_time = "$hours : $minutes";
	
	$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

	$lots = [
			  [ 	
				"name" => "2014 Rossignol District Snowboard",
				"category" => "Доски и лыжи",
				"price" => "10999",
				"url" => "img/lot-1.jpg" 
			  ], 
			  [ 	
				"name" => "DC Ply Mens 2016/2017 Snowboard",
				"category" => "Доски и лыжи",
				"price" => "159999",
				"url" => "img/lot-2.jpg" 
			  ], 
			  [ 	
				"name" => "Крепления Union Contact Pro 2015 года размер L/XL",
				"category" => "Крепления",
				"price" => "8000",
				"url" => "img/lot-3.jpg" 
			  ],
			  [ 	
				"name" => "Ботинки для сноуборда DC Mutiny Charocal",
				"category" => "Ботинки",
				"price" => "10999",
				"url" => "img/lot-4.jpg" 
			  ],
			  [ 	
				"name" => "Куртка для сноуборда DC Mutiny Charocal",
				"category" => "Одежда",
				"price" => "7500",
				"url" => "img/lot-5.jpg" 
			  ],
			  [ 	
				"name" => "Маска Oakley Canopy",
				"category" => "Разное",
				"price" => "5400",
				"url" => "img/lot-6.jpg" 
			  ],
			];
			