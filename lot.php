<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!$is_auth) {
        $error_message = "Делать ставки могут только авторизированные пользователи";
        render403($categories, $is_auth, $user_name, $error_message);
    }
    $rate_allowed = true;
    $new_rate = $_POST;
    $errors = [];
    $lot = get_lot_by_id($link, (int)$new_rate['id']);

    if (!$lot) {
        $error_message = "Вы пытаетесь сделать ставку на несуществующий лот";
        render403($categories, $is_auth, $user_name, $error_message);
    }

    $max_rate = get_max_rate($link, (int)$new_rate['id']);

    if ($max_rate[0]['user_id'] === $_SESSION['user']['id']) {
        $errors['cost'] = 'Последняя ставка сделана Вами';
    }
    $new_rate['cost'] = str_replace(' ', '', $new_rate['cost']);

    if ($new_rate['cost'] < $lot['new_price']) {
        $errors['cost'] = 'Минимальная ставка ' . $lot['new_price'] . ' р';
    }

    if ($lot['user_id'] === $_SESSION['user']['id']) {
        $errors['cost'] = 'Это Ваш лот';
    }

    if (strtotime($lot['end_at']) < time()) {
        $errors['cost'] = 'Торги закончены';
    }

    if (!$errors) {

        $user_id_rate = $_SESSION['user']['id'];
        $lot_id_rate = $lot['id'];
        $amount_rate = $new_rate['cost'];

        $new_rate = insert_rate($link, $amount_rate, $user_id_rate, $lot_id_rate);

        if (!$new_rate) {
            die ("Не удалось добавить ставку, попробуйте позже");
        }

        header('Location: my-bets.php');
        die();
    }

    $title = $lot['name'];
    $history_rates = get_lot_rates($link, $lot['id']);

    $page_content = include_template('lot.php', [
        'lot' => $lot,
        'categories' => $categories,
        'is_auth' => $is_auth,
        'history_rates' => $history_rates,
        'errors' => $errors,
        'rate_allowed' => $rate_allowed
    ]);

    $layout_content = include_template('layout.php', [
        'content' => $page_content,
        'categories' => $categories,
        'title' => $title,
        'is_auth' => $is_auth,
        'user_name' => $user_name
    ]);

    print($layout_content);
    die ();
}

if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    $error_message = "Данной страницы не существует на сайте.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$lot = get_lot_by_id($link, (int)$_GET['id']);

if (empty ($lot)) {
    $error_message = "Лот не найден.";
    render404($categories, $is_auth, $user_name, $error_message);
}

$title = $lot['name'];

$history_rates = get_lot_rates($link, $lot['id']);

if ($is_auth && $history_rates !== [] && ($history_rates[0]['user_id'] === $_SESSION['user']['id'])) {
    $cur_user_rate = true;
} else {
    $cur_user_rate = false;
}

if ($is_auth && (strtotime($lot['end_at']) > time()) && ($lot['user_id'] !== $_SESSION['user']['id'])
    && !$cur_user_rate) {

    $rate_allowed = true;
} else {
    $rate_allowed = false;
}

$page_content = include_template('lot.php', [
    'lot' => $lot,
    'categories' => $categories,
    'is_auth' => $is_auth,
    'history_rates' => $history_rates,
    'rate_allowed' => $rate_allowed
]);

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
