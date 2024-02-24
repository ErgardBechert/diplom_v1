<?php
session_start();
require "function.php";

$email = $_POST['email'] ?? null;
$password = $_POST['password'] ?? null;

if (!empty(get_user_by_email($email))) {
    set_flash_message('danger', 'Пользователь с таким email уже существует');
    redirect_to('page_register.php');
}

add_user($email, $password);

set_flash_message('success', 'Регистрация прошла успешно');

redirect_to('page_login.php');