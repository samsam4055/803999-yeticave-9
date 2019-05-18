<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);
$title = "Поиск";

$errors = [];

$search_words = $_GET['search'] ?? '';
$search_words = trim($search_words);

if(!$search_words) {
	$errors['message'] = 'Не задана поисковая строка';
}

if(!$errors){
	$found_lots = get_sough_lots ($link, $search_words);
	
	if(!$found_lots){
		$errors['message'] = 'Ничего не найдено';
	}
}

if($errors) {
	render_error_page($categories, $is_auth, $user_name, $errors['message']);
}


// $num_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
// $page_link = 'search.php?page=';


$page_content = include_template('search.php', [
	'categories' => $categories,
	'is_auth' => $is_auth,
	'found_lots' => $found_lots,
	'link' => $link
    ]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
    ]);

print($layout_content);
