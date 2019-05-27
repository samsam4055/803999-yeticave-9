<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);
$title = "Поиск";

$errors = [];

$search_words = $_GET['id'] ?? '';
$search_words = trim($search_words);

if (!$search_words) {
    $errors['message'] = 'Не задана поисковая строка';
}

if (!$errors) {
    $total_search_lots = get_total_search_lots($link, $search_words);

    if ($total_search_lots[0]['total'] === 0) {
        $errors['message'] = 'Ничего не найдено';
    }
}

if ($errors) {
    render_error_page($categories, $is_auth, $user_name, $errors['message']);
}

$num_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_link = 'search.php?page=';

$total_search_lots = intval($total_search_lots[0]['total']);
$pages = intval(ceil($total_search_lots / LOTS_PAGE));

if ($num_page <= 0 || $num_page > $pages){
    $error_message = "Страница не найдена.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$ofset = ($num_page - 1) * LOTS_PAGE;

$paginator = range(1, $pages);

$found_lots = get_sough_lots($link, $search_words, LOTS_PAGE, $ofset);

$paginator_content = include_template('paginator.php', [
    'paginator' => $paginator,
    'active_page' => $num_page,
    'page_link' => $page_link,
    'total_pages' => $pages,
    'search' => $search_words
]);


$page_content = include_template('search.php', [
    'categories' => $categories,
    'is_auth' => $is_auth,
    'found_lots' => $found_lots,
    'link' => $link,
    'search_words' => $search_words,
    'paginator' => $paginator_content
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
