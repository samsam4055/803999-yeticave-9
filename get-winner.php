<?php
include_once('vendor/autoload.php');

require_once 'inc/functions.php';
require_once 'inc/data.php';

$lots = get_finished_lots($link);

if (!empty($lots)) {
    foreach ($lots as $key => $lot) {
        $max_rate = get_max_rate($link, $lot['id']);
        if (!empty($max_rate)) {

            $user_id = $max_rate[0]['user_id'];

            $winner = update_lots($link, $user_id, $lot['id']);

            if ($winner) {
                $transport = (new Swift_SmtpTransport('phpdemo.ru', 25))->setUsername('keks@phpdemo.ru')->setPassword('htmlacademy');
                $mailer = new Swift_Mailer($transport);
                $user = get_user($link, $user_id);
                $email = $user[0]['email'];
                $user_name = $user[0]['name'];
                $page = include_template('email.php', [
                    'lot_name' => $lot['name'],
                    'lot_id' => $lot['id'],
                    'user_name' => $user_name
                ]);
                $message = (new Swift_Message('	Ваша ставка победила'))
                    ->setFrom(['keks@phpdemo.ru' => 'Аукцион YetiCave'])
                    ->setTo([$email => $user_name])
                    ->addPart($page, 'text/html');
                $mailer->send($message);
            }
        } 
        else 
        {
            if (time() - strtotime($lot['end_at']) > strtotime(LIFETIME_INACTIVE_LOT))
            {
                remove_lot($link, $lot['id']);
            }
        }
    }
}
