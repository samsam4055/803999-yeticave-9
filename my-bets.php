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

foreach($user_rates as $key => $rate) {
	$is_finishing = false;
	$is_end = false;
	$is_win = $user_id_rates === intval($rate['winner_id']) ? true : false;
	$time_end = strtotime($rate['time']) - time();
	if($time_end <= 3600 && $time_end > 0) {
		$is_finishing = true;
	} else if($time_end <= 0) {
		$is_end = true;
	}
	$user_rates[$key]['is_finishing'] = $is_finishing;
	$user_rates[$key]['is_end'] = $is_end;
	$user_rates[$key]['is_win'] = $is_win;
}

$page_content = include_template('my-bets.php', [
	'categories' => $categories,
	'is_auth' => $is_auth,
	'rates'  => $user_rates
    ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
    ]);

print($layout_content);
