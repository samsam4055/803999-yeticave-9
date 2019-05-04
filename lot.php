<?php

require_once 'inc/functions.php';
require_once 'inc/data.php';

$categories = get_categories($link);

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
    
    $lots = get_lot_by_id($link, (int)$_GET['id']);
    $lot = array();
    foreach($lots as $lot){
		foreach($lot as $val)
		{
        array_push($lot, $val);
		}    
    }
}
else   
	list($page_content, $title) = get_404();

if (is_numeric($_GET['id']) && $lot['id']) {
    $title = $lot['name'];
    $page_content = include_template('lot.php', [
	'lot' => $lot,
	'categories' => $categories,
    ]);
} 
else     
	list($page_content, $title) = get_404();

$layout_content = include_template('layout.php', [
    'content' => $page_content,
    'categories' => $categories,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name
]);

print($layout_content);
