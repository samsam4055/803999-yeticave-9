<?php

require_once 'inc/functions.php'; 
require_once 'inc/data.php'; 

$page_content = include_template('index.php', [
	'lots' => $lots, 
	'categories' => $categories,
	'lot_time' => $lot_time,
	'hours' => $hours	
]);

$layout_content = include_template('layout.php', [
	'content' => $page_content,
	'categories' => $categories,
	'title' => $title,
	'is_auth' => $is_auth,
	'user_name' => $user_name
	
]);

print($layout_content);

?>
