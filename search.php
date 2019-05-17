<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);
$title = "Поиск";

$search_words = $_GET['search'] ?? '';
$search_words = trim($search_words);
$num_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_link = 'search.php?page=';




$page_content = include_template('search.php', [
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
