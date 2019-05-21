<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

$title = "Мой аккаунт";

if (!$is_auth) {
    $error_message = "Вы не авторизировались";
    render403($categories, $is_auth, $user_name, $error_message);
}

$user_id = $_SESSION['user']['id'];
$user = get_user($link, $user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $new_data_user = $_POST;

	$errors = [];

	foreach($new_data_user as $key => $value) {
        if(empty($value)) {
            $errors[$key] = 'Это поле надо заполнить';
        }
	}

	if (!isset($errors['name']) && (ltrim($new_data_user['name']) !== $new_data_user['name'])) {
		$errors['name'] = 'Имя не должно начинаться или состоять только из пробелов';
	}

	if (!isset($errors['name']) && (strlen($new_data_user['name']) > MAX_USER_NAME_LENGTH)) {
		$errors['name'] = 'Имя больше допустимых ' . MAX_USER_NAME_LENGTH . ' символов';
	}

	if (!isset($errors['message']) && (ltrim($new_data_user['message']) !== $new_data_user['message'])) {
		$errors['message'] = 'Контакты не должны начинаться или состоять только из пробелов';
	}

	if (!isset($errors['message']) && (strlen($new_data_user['message']) > MAX_USER_CONTACT_LENGTH)) {
		$errors['message'] = 'Контактные данные больше допустимых ' . MAX_USER_CONTACT_LENGTH . ' символов';
	}

	if($_FILES['image']['name']) {
		
		$without_avatar = false;
		$tmp_name = $_FILES['image']['tmp_name'];

		if (!empty($tmp_name)) {

			$file_type = mime_content_type($tmp_name);

			if ($file_type !== "image/jpeg" && $file_type !== "image/png") {
				$errors['image'] = 'Загрузите картинку лота в формате PNG или JPEG';
			}
		}
		else {
			$errors['image'] = 'Загрузите картинку не более 2Мб в формате PNG или JPEG';
		}
	}
	else {
		$without_avatar = true;
	}	

	if(!$errors) {

		$new_data_user_name = htmlspecialchars($new_data_user['name']);
		$new_data_user_message = htmlspecialchars($new_data_user['message']);

		if($without_avatar){
			$is_updated_user = update_user($link, $user_id, $new_data_user_name, $new_data_user_message);
		}
		else{
			
			if($file_type === 'image/jpeg') {
				$file_type = '.jpeg';
			}
			elseif($file_type === 'image/png') {
			$file_type = '.png';
			}

			$file_name_unic = uniqid() . $file_type;
			$file_url = 'uploads/' .$file_name_unic;
			move_uploaded_file($tmp_name, $file_url);

			$is_updated_user = update_user_with_avatar($link, $user_id, $new_data_user_name, $new_data_user_message, $file_url);
		}
		
		if($is_updated_user) {
			$_SESSION = [];
			header('Location: login.php');
			die();
		}
	}

	if (count($errors)) {

	$page_content = include_template('user.php', [
    'categories' => $categories,
    'errors' => $errors,
	'user' => $user
    ]);
	}
}

else {
$page_content = include_template('user.php', [
    'categories' => $categories,
	'user' => $user
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
