<?php

$main     = new MainClass();
$host     = 'localhost';
$user     = 'пользователь';
$password = 'пароль';
$db       = 'база данных';

$main->connect = new MySQLi($host, $user, $password, $db);

$var = $main->connect;
$var->set_charset("utf8");

if ($var->connect_errno) {
	die('Connect Error ('.$connect->connect_errno.') '.$connect->connect_error);
}
?>