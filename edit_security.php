<?php
    session_start();

    require 'function.php';

    $user_id = $_GET['id'];

    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_repeat = $_POST['password_repeat'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $current_email = get_user_by_id($user_id)['email'];

    if (get_user_by_email($email) && $email !== $current_email)
    {
        set_flash_message('danger', 'Пользователь с таким email уже существует');
        redirect_to('security.php?id=' . $user_id);
    }

    if ($password !== $password_repeat)
    {
        set_flash_message('danger', 'Пароли не совпадают');
        redirect_to('security.php?id=' . $user_id);
    }

    $db = new PDO('mysql:dbname=diplom_v1; host=localhost;', 'root', '');

    $query = 'UPDATE users SET email=:email, password=:password WHERE id=:id';

    $stmt = $db->prepare($query);

    $stmt->execute([
            ':id' => $user_id,
            ':email' => $email,
            ':password' => $hashed_password
    ]);

    $_SESSION['user'] = [
        'id' => $user_id,
        'email' => $email
    ];

    set_flash_message('success', 'Данные пользователя обновлены');
    redirect_to('page_profile.php?id=' . $user_id);