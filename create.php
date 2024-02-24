<?php
    session_start();

    require 'function.php';

    $username = $_POST['username'] ?? null;
    $avatar = $_FILES['avatar'] ?? null;
    $email = $_POST['email'] ?? null;
    $phone = $_POST['phone'] ?? null;
    $address = $_POST['address'] ?? null;
    $password = $_POST['password'] ?? null;
    $job = $_POST['job'] ?? null;
    $vk = $_POST['vk'] ?? null;
    $inst = $_POST['inst'] ?? null;
    $tg = $_POST['tg'] ?? null;
    $status_id = $_POST['status'] ?? null;

    if (get_user_by_email($email)){
        set_flash_message('danger', 'Пользователь с таким email уже существует');
        redirect_to('create_user.php');
    }

    $user_id = add_user($email, $password);

    if (empty($username) || empty($job) || empty($phone) || empty($address))
    {
        edit($username, $job, $phone, $address, $user_id);
    }

    if (empty($status_id))
    {
        set_status($status_id, $user_id);
    }

    if (empty($avatar))
    {
        upload_avatar($avatar, $user_id);
    }

    if (empty($vk) || empty($tg) || empty($inst))
    {
        add_social_links($vk, $tg, $inst, $user_id);
    }

    set_flash_message('success', 'Пользователь успешно создан');
    redirect_to('users.php');


