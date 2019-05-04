<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){

  $lot = get_lot_by_id($link, (int)$_GET['id']);
}
else {
  http_response_code(404);
  $title = "Страница не найдена";
  $page_content = include_template ('404.php', [
    'categories' => $categories
    ]);
}

if (is_numeric($_GET['id']) && $lot['id']) {
  $title = $lot['name'];
  $page_content = include_template('lot.php', [
    'lot' => $lot,
    'categories' => $categories,
    ]);
}
else {
http_response_code(404);
  $title = "Страница не найдена";
  $page_content = include_template ('404.php', [
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
