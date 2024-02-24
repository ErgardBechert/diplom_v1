<?php
    session_start();

    require 'function.php';

    $user_id = $_GET['id'];

    $username = $_POST['username'];
    $job = $_POST['job'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    edit($username, $job, $phone, $address, $user_id);

    set_flash_message('success', 'Данные успешно отредактированы');
    redirect_to('page_profile.php?id=' . $user_id);