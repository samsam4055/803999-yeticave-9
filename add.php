<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Добавление лота";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_lot = $_POST;

	$required = ['category', 'lot-name', 'message', 'lot-rate', 'lot-step', 'lot-date'];

	$dict = ['category' => 'категория', 'lot-name' => 'имя лота', 'message' => 'описание лота',
	'lot-rate' => 'cтавка лота', 'lot-step' => 'шаг ставки', 'lot-date' => 'дата лота'
	];

	$errors = [];

	foreach($new_lot as $key => $value) {
        if(empty($new_lot[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
        }
        if($key === 'category' && $value === 'Выберите категорию') {
            $errors[$key] = 'Выберите категорию';
        }
	}

	if(!check_positive_number($new_lot['lot-rate'])) {
		$errors['lot-rate'] = 'Введите число больше ноля';
	}

	if(!check_positive_number($new_lot['lot-step'])) {
		$errors['lot-step'] = 'Введите число больше ноля';
	}

	if(!is_date_valid($new_lot['lot-date'])) {
		$errors['lot-date'] = 'Укажите дату завершения торгов в формате ДД.ММ.ГГГГ';
	}

	if(!is_date_tomorrow($new_lot['lot-date'])) {
		$errors['lot-date'] = 'Дата завершения торгов должна быть больше, чем текущая дата';
	}

	if($_FILES['image']['name']) {
	
		$tmp_name = $_FILES['image']['tmp_name'];
		$path = $_FILES['image']['name'];
	
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
		
		if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
			$errors['image'] = 'Загрузите картинку лота в формате PNG или JPEG';
		}
	}
	else {
		$errors['image'] = 'Вы не загрузили изображение лота';
	}

	if(!$errors) {
		if($file_type === 'image/jpeg') {
			$file_type = '.jpeg';
		} elseif($file_type === 'image/png') {
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
		
		$new_lot_category_id = get_category_id($link, $new_lot['category']);
		
		insert_lot($link, $new_lot_name, $new_lot_message, $file_url, $new_lot_end_at, $new_lot_step, $new_lot_price, $new_lot_category_id);

	}
	
	if (count($errors)) {

	$page_content = include_template('add-lot.php', [
    'categories' => $categories,
	'errors' => $errors
    ]);
    }
	else {
		header('Location: lot.php?id=5'); //  . $lot_id  переадресация на страницу просмотра лота, временно не подтягиваем id
		die();
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
