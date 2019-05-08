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
		
    }
	
	if (count($errors)) {

	$page_content = include_template('add-lot.php', [
    'categories' => $categories,
	'errors' => $errors
    ]);
    }
	else {
		header('Location: lot.php?id=5'); //  . $lot_id  переадресация на страницу просмотра лота
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
