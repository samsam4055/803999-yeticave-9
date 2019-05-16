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

function db_get_prepare_stmt($link, $sql, $data = [])
{
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

	if (!mysqli_stmt_execute($stmt)) {
		die("Ошибка MySQL: " . mysqli_error($link));
	}
	$result = mysqli_stmt_get_result($stmt);

	if (!$result) {
		die("Ошибка MySQL: " . mysqli_error($link));
	}
	return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

function get_categories($link): array
{
	$sql_cat = 'SELECT `code`, `name`, `id` FROM categories';

	return fetch_data($link, $sql_cat);
}

function get_active_lots($link): array
{
	$sql_lots = "SELECT lots.name AS name, lots.id, categories.name
	AS category, start_price, img_url, end_at FROM lots
	JOIN categories ON categories.id = category_id
	WHERE end_at > NOW() and winner_id IS NULL
	ORDER BY lots.created_at DESC LIMIT 9";

	return fetch_data($link, $sql_lots);
}

function get_lot_by_id($link, int $lot_id): array
{
	$sql_one_lot = "SELECT lots.name AS name, lots.id, lots.description, categories.name
	AS category, start_price, img_url, end_at, MAX(IF(amount IS NULL, start_price, amount)) AS price, MAX(IF(amount IS NULL, start_price, amount))+rate_step AS new_price FROM lots
	LEFT JOIN categories ON categories.id = category_id
	LEFT JOIN rates r ON lots.id = r.lot_id
	WHERE lots.id = ${lot_id} GROUP BY lots.id";
	$result = fetch_data($link, $sql_one_lot);
	return count($result) === 1 ? $result[0] : [];
}

function render404($categories, $is_auth, $user_name, $error_message)
{
	http_response_code(404);
	$title = "Страница не найдена";
	$page_content = include_template ('404.php', [
	'categories' => $categories,
	'error_message' => $error_message
	]);

	$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'title' => $title,
	'is_auth' => $is_auth,
	'user_name' => $user_name
	]);

	die($layout_content);
}

function render403($categories, $is_auth, $user_name, $error_message)
{
	http_response_code(403);
	$title = "Доступ запрещен";
	$page_content = include_template ('403.php', [
	'categories' => $categories,
	'error_message' => $error_message
	]);

	$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'title' => $title,
	'is_auth' => $is_auth,
	'user_name' => $user_name
	]);

	die($layout_content);
}

function is_positive_number($value)
{
	if(!filter_var($value, FILTER_VALIDATE_INT) || $value <= 0) {
	    return false;
	}
	return true;
}

function is_date_valid(string $date): bool
{
	$format_to_check = 'Y-m-d';
	$dateTimeObj = date_create_from_format($format_to_check, $date);

	return $dateTimeObj !== false && array_sum(date_get_last_errors()) === 0;
}

function is_date_from_future(string $date): bool
{
	$new_lot_date = strtotime($date);
	$date_end = strtotime('tomorrow');

	if($new_lot_date < $date_end) {
		return false;
	}
	return true;
}

function insert_data($link, string $sql): int
{
	$stmt = db_get_prepare_stmt($link, $sql);
	$result = mysqli_stmt_execute($stmt);

	if (!$result) {
		die ("Не удалось добавить данные в базу");
	}
	$received_id = mysqli_insert_id($link);

	if ($received_id <= 0 ) {
		die ("Не удалось получить id записи");
	}
	return $received_id;
}

function insert_lot($link, $new_lot_name, $new_lot_message, $file_url, $new_lot_end_at, $new_lot_step, $new_lot_price, $new_lot_user_id, $new_lot_category_id): int
{
	$add_lot = "INSERT INTO lots
	(name, description, img_url, start_price, end_at, rate_step, user_id, category_id) VALUES
	('$new_lot_name', '$new_lot_message', '$file_url', '$new_lot_price', '$new_lot_end_at', '$new_lot_step', '$new_lot_user_id', '$new_lot_category_id')";

	$lot_id = insert_data($link, $add_lot);

	return $lot_id;
}

function is_registered_email($link, string $email): bool
{
	$sql_email = "SELECT id FROM users WHERE email = '$email'";
	$verifiable_email = fetch_data($link, $sql_email);

	if($verifiable_email) {
		return true;
	}
	return false;
}

function insert_user($link, $new_user_name, $new_user_message, $new_user_password, $new_user_email): int
{
	$add_user = "INSERT INTO users (email, name, password, contact)
	VALUES ('$new_user_email', '$new_user_name', '$new_user_password', '$new_user_message')";

	$user_id = insert_data($link, $add_user);

	return $user_id;
}

function get_user_by_email($link, $user_email): array
{
	$sql_user_by_email = "SELECT * FROM users WHERE email = '$user_email'";
	$result = fetch_data($link, $sql_user_by_email);
	return count($result) === 1 ? $result[0] : [];
}

function get_user_rates($link, $user_id_rates): array
{
	$sql_user_rates = "SELECT rates.amount, lots.id, lots.img_url, lots.name, categories.name AS category,
		lots.end_at AS time, rates.created_at, lots.winner_id, users.contact
		FROM rates
		JOIN lots ON lots.id = rates.lot_id
		JOIN users ON users.id = lots.user_id
		JOIN categories ON categories.id = lots.category_id
		WHERE rates.user_id = '$user_id_rates'
		ORDER BY rates.created_at DESC";
	
	return fetch_data($link, $sql_user_rates);
}

function render_error_page($categories, $is_auth, $user_name, $error_message)
{
	$title = "Данные не найдены";
	$page_content = include_template ('error-page.php', [
	'categories' => $categories,
	'error_message' => $error_message
	]);

	$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'title' => $title,
	'is_auth' => $is_auth,
	'user_name' => $user_name
	]);

	die($layout_content);
}

function get_noun_plural_form (int $number, string $one, string $two, string $many): string
{
	$number = (int) $number;
	$mod10 = $number % 10;
	$mod100 = $number % 100;

	switch (true) {
		case ($mod100 >= 11 && $mod100 <= 20):
			return $many;

		case ($mod10 > 5):
			return $many;

		case ($mod10 === 1):
			return $one;

		case ($mod10 >= 2 && $mod10 <= 4):
			return $two;

		default:
			return $many;
	}
}

function show_user_frendly_time($time) {
	$current_time = time();
	$time_lives_a_lot = strtotime($time);
	$time_lives_a_lot = $current_time - $time_lives_a_lot;
	$hours = floor($time_lives_a_lot / 3600);
	$minutes = floor($time_lives_a_lot % 3600 / 60);

	if($hours == 0) {
		$noun_plural_form_minutes = get_noun_plural_form ($minutes, " минуту назад", " минуты назад", " минут назад");
		$time = $minutes . $noun_plural_form_minutes;
		return $time;
	} elseif($hours > 0 && $hours < 24) {
		$noun_plural_form_hours = get_noun_plural_form ($hours, " час назад", " часа назад", " часов назад");
		$time = $hours . $noun_plural_form_hours;
		return $time;
	}
	$date = date('d.m.Y', strtotime($time));
	$time = date('H:i', strtotime($time));
	return $date . ' ' . $time;
}

function get_lot_rates($link, $lot_id_rates): array
{
	$sql_lot_rates = "SELECT rates.amount, rates.created_at, users.name
		FROM rates
		JOIN lots ON lots.id = rates.lot_id
		JOIN users ON users.id = rates.lot_id
		WHERE rates.lot_id = '$lot_id_rates'
		ORDER BY rates.created_at DESC";
	
	return fetch_data($link, $sql_lot_rates);
}
