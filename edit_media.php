<?php
    session_start();

    require 'function.php';

    $user_id = $_GET['id'];

    $avatar = $_FILES['avatar'] ?? null;

    upload_avatar($avatar, $user_id);

    set_flash_message('success', 'Аватар успешно загружен');
    redirect_to('users.php');