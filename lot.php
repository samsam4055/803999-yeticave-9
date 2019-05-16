<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (!$is_auth) {
    $error_message = "Делать ставки могут только авторизированные пользователи";
    render403($categories, $is_auth, $user_name, $error_message);
	}
	
	$new_rate = $_POST;

	$errors = [];

	
	
	header('Location: my-bets.php');
			die();
}


if (empty($_GET['id']) || !is_numeric($_GET['id'])){
    $error_message = "Данной страницы не существует на сайте.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$lot = get_lot_by_id($link, (int)$_GET['id']);

if (empty ($lot)) {
    $error_message = "Лот не найден.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$title = $lot['name'];



$history_rates = get_lot_rates($link, $lot['id']);

$page_content = include_template('lot.php', [
    'lot' => $lot,
    'categories' => $categories,
    'is_auth' => $is_auth,
	'history_rates' => $history_rates
    ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
    ]);

print($layout_content);
