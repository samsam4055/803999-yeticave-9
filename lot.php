<?php

$title = 'Лот';

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if (isset($_GET['id']) && !empty($_GET['id'])){
    $sql_lot_id= $_GET['id'];
    $lots = get_lot_by_id($link, $sql_lot_id);

    $page_content = include_template('lot.php', [
        'lots' => $lots,
        'categories' => $categories,
    ]);
} 
else {
    http_response_code(404);
    $content = require_once ('pages\404.html');
}

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
