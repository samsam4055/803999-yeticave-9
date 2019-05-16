<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);
$title = "Мои ставки";

if (!$is_auth) {
    $error_message = "Вы не авторизированы, доступ запрещен";
    render403($categories, $is_auth, $user_name, $error_message);
}

$user_id_rates = $_SESSION['user']['id'];
$user_rates = get_user_rates($link, $user_id_rates);

if(empty($user_rates)) {
	$error_message = 'Вы ещё не делали ставки по выставленным лотам';
	render_error_page($categories, $is_auth, $user_name, $error_message);
}

$page_content = include_template('my-bets.php', [
    'categories' => $categories,
    'is_auth' => $is_auth
    ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
    ]);

print($layout_content);
