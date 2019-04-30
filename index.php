<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

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
