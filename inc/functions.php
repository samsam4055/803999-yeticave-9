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

function get_hours_and_minutes_till_end(string $end_at): array
{
    $seconds_till_end = strtotime($end_at) - time();

    return $seconds_till_end > 0
	? [ floor($seconds_till_end / 3600), floor(($seconds_till_end % 3600) / 60) ]
	: [0, 0];
}

function get_lot_timer(string $end_at): string
{
    list($hours, $minutes) = get_hours_and_minutes_till_end($end_at);

    return sprintf("%d:%02d", $hours, $minutes);
}

function add_time_class(string $end_at): string
{
    list($hours, $minutes) = get_hours_and_minutes_till_end($end_at);

    return $hours <= 0 ? 'timer--finishing' : '';
}

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}

function fetch_data($link, string $sql): array 
{
	$stmt = db_get_prepare_stmt($link, $sql);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);

	if (!$result) {
		$error = mysqli_error($link);
		print("Ошибка MySQL: " . $error);
	}
	else
		return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_categories($link): array
{
    if (!$link) {
    $error = mysqli_connect_error();
    print("Ошибка подключения MySQL: " . $error);
	}
	else {
		$sql_cat = 'SELECT `code`, `name` FROM categories';

		return fetch_data($link, $sql_cat);
	}
}

function get_active_lots($link): array
{
	if (!$link) {
	$error = mysqli_connect_error();
	print("Ошибка подключения MySQL: " . $error);
	}
	else {
		$sql_lots = "SELECT lots.name AS name, categories.name
		AS category, start_price, img_url, end_at FROM lots
		JOIN categories ON categories.id = category_id
		WHERE end_at > NOW() and winner_id IS NULL
		ORDER BY lots.created_at DESC LIMIT 9";

		return fetch_data($link, $sql_lots);
	}
}
