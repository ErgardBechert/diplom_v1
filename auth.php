<?php
session_start();

require 'function.php';

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;


if (!empty(login($email, $password)))
{
    redirect_to('users.php');
} else {
    set_flash_message('danger', 'Почта или пароль не верны');
    redirect_to('page_login.php');
}