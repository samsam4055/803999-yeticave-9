<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';
require_once 'get-winner.php';
$title = 'Мои лоты';
$categories = get_categories($link);

if (!$is_auth) {
    $error_message = "Вы не авторизированы, доступ запрещен";
    render403($categories, $is_auth, $user_name, $error_message);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	
	if (!$is_auth) {
    $error_message = "Вы не авторизированы, доступ запрещен";
    render403($categories, $is_auth, $user_name, $error_message);
    }
	$remove_lot_id = $_POST['remove'];
	
	$lot = get_removable_lot($link, $remove_lot_id);

	if (!is_null($lot[0]['amount']) || $lot[0]['user_id'] !== $_SESSION['user']['id']){
		$error_message = "Вы пытаетесь удилить лот, на который уже были ставки или не свой лот";
		render403($categories, $is_auth, $user_name, $error_message);
	}

}


$user_id = $_SESSION['user']['id'];
$lots = get_my_lots($link, $user_id);

$page_content = include_template('my-lots.php', [
    'lots' => $lots,
    'categories' => $categories,
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
