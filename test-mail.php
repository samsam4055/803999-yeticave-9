<?php
require_once('vendor/autoload.php');

require_once 'inc/functions.php';
require_once 'inc/data.php';
	
if(1){
	$transport = (new Swift_SmtpTransport('phpdemo.ru', 25))->setUsername('keks@phpdemo.ru')->setPassword('htmlacademy');
	$mailer = new Swift_Mailer($transport);

	$email = 'andry9507@rambler.ru'; // $user[0]['email'];
	$user_name = $user[0]['name'];
	$page = include_template('email.php', [
	'lot_name'  => $lot['name'],
	'lot_id'    => $lot['id'],
	'user_name' => $user_name
	]);
	$message = (new Swift_Message('	Ваша ставка победила'))
	->setFrom(['keks@phpdemo.ru' => 'Аукцион YetiCave'])
	->setTo([$email => $user_name])
	->addPart($page, 'text/html');
	$mailer->send($message);
}
