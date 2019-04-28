<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';


$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($link, "utf8");

if (!$link) {
    $error = mysqli_connect_error();
    print("Ошибка подключения MySQL: " . $error);
}
else {
    $sql = 'SELECT `code`, `name` FROM categories';
    $result = mysqli_query($link, $sql);

    if (!$result) {
        $error = mysqli_error($link);
        print("Ошибка MySQL: " . $error);
    }
    else
        $categories = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $sql = "SELECT lots.name AS name, categories.name
    AS category, start_price, img_url, end_at FROM lots
    JOIN categories ON categories.id = category_id
    ORDER BY lots.end_at ASC";
    $result = mysqli_query($link, $sql);

    if (!$result) {
        $error = mysqli_error($link);
        print("Ошибка MySQL: " . $error);
    }
    else
        $lots = mysqli_fetch_all($result, MYSQLI_ASSOC);
}

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
