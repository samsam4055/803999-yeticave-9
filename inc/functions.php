<?php

// функция форматирования цены

	function format_price (float $price): string {
		$price = ceil($price);
		$price = number_format($price, 0, '', ' ');
		return $price;
	};
	
// 	функция подключения шаблонов

	function include_template($name, array $data = []) {
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

// функция фильтрации пользовательских данных

function esc($str) {
	//$text = htmlspecialchars($str);
	$text = strip_tags($str);

	return $text;
}
