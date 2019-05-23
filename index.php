<?php
$is_auth = 0;
$title = 'Главная';

require_once 'inc/functions.php';
require_once 'inc/data.php';
include_once 'get-winner.php';

$categories = get_categories($link);
$lots = get_active_lots($link);

$page_content = include_template('index.php', [
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
