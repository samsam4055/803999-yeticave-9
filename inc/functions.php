<?php

function format_price(float $price): string
{
    $price = ceil($price);
    $price = number_format($price, 0, '', ' ');
    return $price;
}

function include_template(string $name, array $data = []): string
{
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
}

function esc(string $str): string
{
    $text = strip_tags($str);
    return $text;
}

function get_lot_minutes_till_end(string $end_at): string
{
    $end_timestamp = strtotime($end_at);
    $secs_to_end = $end_timestamp - time();
	
	if ($secs_to_end > 0) {
    $hours = floor($secs_to_end / 3600);
    $minutes = floor(($secs_to_end % 3600) / 60);
    $minutes = ($minutes < 10) ? 0 . $minutes : $minutes;
	} 
	else {
	$hours = 0;  
	$minutes = "00";
	}
    
	return "$hours : $minutes";
}

function add_time_class(string $lot_end_at): string
{
    $end_timestamp = strtotime($lot_end_at);
    $secs_to_end = $end_timestamp - time();
    $hours = floor($secs_to_end / 3600);
    return $hours <= 0 ? 'timer--finishing' : '';
}
