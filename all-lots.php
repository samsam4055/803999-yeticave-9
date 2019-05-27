<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
} else {
	$error_message = "Страница не найдена.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$total_search_lots = get_total_category_lots($link, $category_id);

if ($total_search_lots[0]['total'] === 0) {
    $errors = 'В этой категории ничего не найдено ';
    render_error_page($categories, $is_auth, $user_name, $errors);
}

$num_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page_link = 'all-lots.php?page=';

$total_search_lots = intval($total_search_lots[0]['total']);
$pages = intval(ceil($total_search_lots / LOTS_PAGE));

if ($num_page <= 0 || $num_page > $pages){
    $error_message = "Страница не найдена.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$ofset = ($num_page - 1) * LOTS_PAGE;

$paginator = range(1, $pages);

$found_lots = get_lots_by_category($link, $category_id, LOTS_PAGE, $ofset);

$title = "Все лоты в категории " . $found_lots[0]['category'];

$paginator_content = include_template('paginator.php', [
    'paginator' => $paginator,
    'active_page' => $num_page,
    'page_link' => $page_link,
    'total_pages' => $pages,
    'search' => $category_id
]);

$page_content = include_template('all-lots.php', [
    'categories' => $categories,
    'is_auth' => $is_auth,
    'found_lots' => $found_lots,
    'link' => $link,
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
