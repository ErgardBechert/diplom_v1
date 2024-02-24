<?php
    session_start();

    require 'function.php';

    if (is_not_login_in())
    {
        redirect_to('page_login.php');
    }

    $user_id = $_GET['id'];

    if (!is_admin(get_authenticated_user()))
    {
        if (!is_author(get_authenticated_user()['id'], $user_id))
        {
            set_flash_message('danger', 'Можно редактировать только свой профиль');
            redirect_to('users.php');
        }
    }

    if (get_authenticated_user()['id'] == $user_id)
    {
        delete($user_id);
        $_SESSION['user'] = '';
        set_flash_message('success', 'Ваш профиль успешно удален!');
        redirect_to('page_register.php');
    }

    delete($user_id);
    set_flash_message('success', 'Профиль пользователя успешно удален!');
    redirect_to('users.php');

