<?php

	function format_price (float $price): string {
		$price = ceil($price);
		$price = number_format($price, 0, '', ' ');
		return $price;
	};

	function include_template(string $name, array $data = []): string {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
	};

	function esc(string $str): string {
		$text = strip_tags($str);

		return $text;
	};

	date_default_timezone_set("Europe/Moscow");
	setlocale(LC_ALL, 'ru_RU');
	$ts_midnight = strtotime('tomorrow');
	$secs_to_midnight = $ts_midnight - time();

	$hours = floor($secs_to_midnight / 3600);
	$minutes = floor(($secs_to_midnight % 3600) / 60);
	$minutes = ($minutes < 10) ? 0 . $minutes : $minutes;
	$lot_time = "$hours : $minutes";

	function add_time_class($timer_finishing) {
		$ts_midnight = strtotime('tomorrow');
		$secs_to_midnight = $ts_midnight - time();
		$hours = floor($secs_to_midnight / 3600); 
		
		if (!$hours){
			$timer_finishing = 'timer--finishing';
		}	
		else $timer_finishing = '';
	
	return $timer_finishing;
	}; 
