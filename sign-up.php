<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Регистрация аккаунта";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_user = $_POST;

    $errors = [];

    foreach ($new_user as $key => $value) {
        if (empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
    }

    if (filter_var($new_user['email'], FILTER_VALIDATE_EMAIL) === false) {
        $errors['email'] = 'Введите корректный e-mail';
    }

    if (!isset($errors['email']) && is_registered_email($link, $new_user['email'])) {
        $errors['email'] = 'Пользователь с этим e-mail уже зарегистрирован';
    }

    if (!isset($errors['name']) && (ltrim($new_user['name']) !== $new_user['name'])) {
        $errors['name'] = 'Имя не должно начинаться или состоять только из пробелов';
    }

    if (!isset($errors['name']) && (strlen($new_user['name']) > MAX_USER_NAME_LENGTH)) {
        $errors['name'] = 'Имя больше допустимых ' . MAX_USER_NAME_LENGTH . ' символов';
    }

    if (!isset($errors['message']) && (ltrim($new_user['message']) !== $new_user['message'])) {
        $errors['message'] = 'Контакты не должны начинаться или состоять только из пробелов';
    }

    if (!isset($errors['message']) && (strlen($new_user['message']) > MAX_USER_CONTACT_LENGTH)) {
        $errors['message'] = 'Контактные данные больше допустимых ' . MAX_USER_CONTACT_LENGTH . ' символов';
    }

    if (!$errors) {

        $new_user_name = htmlspecialchars($new_user['name']);
        $new_user_message = htmlspecialchars($new_user['message']);
        $new_user_password = password_hash($new_user['password'], PASSWORD_DEFAULT);
        $new_user_email = htmlspecialchars($new_user['email']);

        $new_user_id = insert_user($link, $new_user_name, $new_user_message, $new_user_password, $new_user_email);

        if ($new_user_id) {

            header('Location: login.php');
            die();
        }
    }

    if (count($errors)) {

        $page_content = include_template('sign-up.php', [
            'categories' => $categories,
            'errors' => $errors
        ]);
    }
} else {
    $page_content = include_template('sign-up.php', [
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
