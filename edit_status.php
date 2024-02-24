<?php
    session_start();

    require 'function.php';

    $user_id = $_GET['id'];
    $status = $_POST['status'];

    set_status($status, $user_id);
    set_flash_message('success', 'Статус "'. get_status_name($status) .'" успешно установлен');
    redirect_to('page_profile.php?id=' . $user_id);