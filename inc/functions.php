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
 
 /*   разбираюсь с добавлением класса timer--finishing
function add_time_class($hours) {
	$timer_finishing = '';
	$ts_midnight = strtotime('tomorrow');
	$secs_to_midnight = $ts_midnight - time();

	$hours = floor($secs_to_midnight / 3600);
	 
	if ($hours === 0) {
		$timer_finishing = 'timer--finishing';
		
	}
	return $timer_finishing;
}; 
	*/
