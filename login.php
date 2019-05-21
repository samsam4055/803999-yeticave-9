<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Вход";

if ($is_auth) {
    $error = "Вы уже авторизировались.";
    render403($categories, $is_auth, $user_name, $error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login_form = $_POST;

    $errors = [];

    foreach ($login_form as $key => $value) {
        if (empty($value)) {
            $errors[$key] = 'Заполните поле для входа';
        }
    }

    if (filter_var($login_form['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Введите корректный e-mail';
    } else {
        $user_email = htmlspecialchars($login_form['email']);

        $user = get_user_by_email($link, $user_email);

        if (!$user) {
            $errors['email'] = 'Пользователь с таким e-mail не найден';
        }
    }

    if (!$errors) {

        if (!password_verify($login_form['password'], $user['password'])) {
            $errors['password'] = 'Неверный email или пароль';
        } else {
            $_SESSION['user'] = $user;
            header('Location: index.php');
            die ();
        }
    }

    if (count($errors)) {

        $page_content = include_template('login.php', [
            'categories' => $categories,
            'errors' => $errors
        ]);
    }
} else {
    $page_content = include_template('login.php', [
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
