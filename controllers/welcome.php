<?php

if (isset($_SESSION['user_id'])) {
	redirect('/home');
}

$pageTitle = 'Welcome';
$navbar = "/public/css/navbar.css";
$style = "/public/css/auth.css";

require "views/welcome.view.php";
