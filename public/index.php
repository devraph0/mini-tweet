<?php
session_start();
require 'autoload.php';
$user = new controllers\UsersController();
$tweets = new controllers\TweetsController();
if (!isset($_SESSION['token'])) {
	include 'auth.php';
	return;
}
include 'home.php';
?>