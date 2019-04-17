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

