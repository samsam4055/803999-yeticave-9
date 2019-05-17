<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Добавление лота";

if (!$is_auth) {
    $error_message = "Вы не авторизированы, доступ запрещен";
    render403($categories, $is_auth, $user_name, $error_message);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$new_lot = $_POST;

	$errors = [];

	foreach($new_lot as $key => $value) {
        if(empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
	}

	if($new_lot['category'] <= 0 ) {
		$errors['category'] = 'Выберите категорию';
	}

	if (!isset($errors['lot-name']) && (strlen($new_lot['lot-name']) > MAX_LOT_NAME_LENGTH)) {
		$errors['lot-name'] = 'Наименование больше допустимых ' . MAX_LOT_NAME_LENGTH . ' символов';
	}

	if (!isset($errors['message']) && (strlen($new_lot['message']) > MAX_LOT_DESC_LENGTH)) {
		$errors['message'] = 'Описание больше допустимых ' . MAX_LOT_DESC_LENGTH . ' символов';
	}

	if(!is_positive_number($new_lot['lot-rate'])) {
		$errors['lot-rate'] = 'Введите целое число больше 0';
	}

	if(!is_positive_number($new_lot['lot-step'])) {
		$errors['lot-step'] = 'Введите целое число больше 0';
	}

	if(!is_date_valid($new_lot['lot-date'])) {
		$errors['lot-date'] = 'Укажите дату завершения торгов в формате ГГГГ.ММ.ДД';
	}

	if(!is_date_from_future($new_lot['lot-date'])) {
		$errors['lot-date'] = 'Дата завершения торгов должна быть больше, чем текущая дата';
	}

	if($_FILES['image']['name']) {

		$tmp_name = $_FILES['image']['tmp_name'];

		if (!empty($tmp_name)) {

			$file_type = mime_content_type($tmp_name);

			if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
				$errors['image'] = 'Загрузите картинку лота в формате PNG или JPEG';
			}
		}
		else {
			$errors['image'] = 'Загрузите картинку не более 2Мб в формате PNG или JPEG';
		}
	}
	else {
		$errors['image'] = 'Вы не загрузили изображение лота';
	}

	if(!$errors) {
		if($file_type === 'image/jpeg') {
			$file_type = '.jpeg';
		}
		elseif($file_type === 'image/png') {
		$file_type = '.png';
		}

		$file_name_unic = uniqid() . $file_type;
		$file_url = 'uploads/' .$file_name_unic;
		move_uploaded_file($tmp_name, $file_url);

		$new_lot['lot-name'] = htmlspecialchars($new_lot['lot-name']);
		$new_lot['message'] = htmlspecialchars($new_lot['message']);

		$new_lot_name = $new_lot['lot-name'];
		$new_lot_message = $new_lot['message'];
		$new_lot_end_at = $new_lot['lot-date'];
		$new_lot_step = $new_lot['lot-step'];
		$new_lot_price = $new_lot['lot-rate'];
		$new_lot_user_id = $_SESSION['user']['id'];
		$new_lot_category_id = $new_lot['category'];

		$new_lot_id = insert_lot($link, $new_lot_name,
			$new_lot_message, $file_url, $new_lot_end_at, $new_lot_step,
			$new_lot_price, $new_lot_user_id, $new_lot_category_id);

		if($new_lot_id) {

		header('Location: lot.php?id='. $new_lot_id);
			die();
		}
	}

	if (count($errors)) {

	$page_content = include_template('add-lot.php', [
    'categories' => $categories,
    'errors' => $errors
    ]);
	}
}

else {
$page_content = include_template('add-lot.php', [
    'categories' => $categories
    ]);
}

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'title' => $title,
	'is_auth' => $is_auth,
	'user_name' => $user_name
	]);

print($layout_content);
