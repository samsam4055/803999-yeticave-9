<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Регистрация аккаунта";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_user = $_POST;

	$errors = [];

	foreach($new_user as $key => $value) {
        if(empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
	}
	
	
	if(!$errors) {
		
	header('Location: login.php');
	die();
	
	}

	if (count($errors)) {

	$page_content = include_template('sign-up.php', [
    'categories' => $categories,
    'errors' => $errors
    ]);
	}
}

else {
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
