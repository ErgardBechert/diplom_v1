<?php


function get_user_by_email($email)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'SELECT * from users WHERE email = :email';

    $stmt = $db->prepare($query);

    $stmt->execute([':email' => $email]);

    return  $stmt->fetch(PDO::FETCH_ASSOC);
};

function get_statuses()
{
    $db = new PDO('mysql:dbname=diplom_v1; host=localhost;', 'root', '');

    $query = 'SELECT * FROM statuses';

    $stmt = $db->prepare($query);

    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};

function get_users()
{
    $db = new PDO('mysql:dbname=diplom_v1; host=localhost;', 'root'. '');
    $query = 'SELECT * FROM users';
    $stmt = $db->prepare($query);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
};

function get_authenticated_user() {
    return get_user_by_email($_SESSION['user']['email']);
};

function get_status_color($status_id){

    switch ($status_id) {
        case 1:
            echo 'status-success';
            break;
        case 2:
            echo 'status-warning';
            break;
        case 3:
            echo 'status-danger';
            break;
    };
};

function get_status_name($status_id) {
    $db = new PDO('mysql:dbname=diplom_v1; host=localhost;', 'root', '');

    $query = 'SELECT name FROM statuses WHERE id = :id';

    $stmt = $db->prepare($query);

    $stmt->execute([
        ':id' => $status_id
    ]);

    $status_name = $stmt->fetch(PDO::FETCH_ASSOC)['name'];

    return $status_name;
};

function add_user($email, $password)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'INSERT INTO users (email, password) 
    VALUES (:email, :password)';

    $stmt = $db->prepare($query);

    // Хешироваие пароля
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt->execute([':email' => $email, ':password' => $hashed_password]);

    return get_user_by_email($email)['id'];
};

function login($email, $password) {
    $db = new PDO('mysql:dbname=diplom_v1;host=localhost;', 'root', '');
    $query = 'SELECT * FROM users WHERE email = :email';
    $stmt = $db->prepare($query);
    $stmt->execute([':email' => $email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!get_user_by_email($email) or !password_verify($password, $user['password']))
    {
        return false;

    } else {
        $_SESSION['user'] = [
            'id' => $user['id'],
            'email' => $user['email'],
        ];

        return true;
    };
};

function logout()
{
    unset($_SESSION['user']);
};

function delete($user_id)
{
    $db = new PDO('mysql:dbname=diplom_v1; host=localhost;', 'root', '');
    $query = 'DELETE from users WHERE id=:id';
    $stmt = $db->prepare($query);
    $stmt->execute([
        ':id' => $user_id
    ]);
};

function edit($username, $job, $phone, $address, $user_id)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'UPDATE users SET username = :username, job = :job, phone = :phone, address = :address WHERE id = :id';

    $stmt = $db->prepare($query);

    $stmt->execute([':id' => $user_id, ':username' => $username, ':job' => $job, ':phone' => $phone, ':address' => $address]);
};

function set_status($status_id, $user_id)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'UPDATE users SET status_id = :status_id WHERE id = :id';

    $stmt = $db->prepare($query);

    $stmt->execute([':status_id' => $status_id, ':id' => $user_id]);
};

function has_image($user_id)
{
    $user = get_user_by_id($user_id);

    if (!empty($user['avatar']))
    {
        return $user['avatar'];
    };

    return 'img/demo/avatars/avatar-m.png';
};

function upload_avatar($image, $user_id)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');
    $query = 'UPDATE users SET avatar = :avatar WHERE id = :id';
    $stmt = $db->prepare($query);

    $upload_dir = './img/uploads/';
    $result = pathinfo($image['name']);

    $upload_file = $upload_dir . uniqid() . '.' . $result['extension'];

    if (move_uploaded_file($image['tmp_name'], __DIR__ . $upload_file))
    {
        $stmt->execute([':avatar' => $upload_file, ':id' => $user_id]);
    }
};

function add_social_links($vk, $tg, $inst, $user_id)
{
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'UPDATE users SET vk = :vk, tg = :tg, inst = :inst WHERE id = :id';

    $stmt = $db->prepare($query);

    $stmt->execute([':vk' => $vk, ':tg' => $tg, ':inst' => $inst, ':id' => $user_id]);
};

function set_flash_message($name, $message)
{
    $_SESSION[$name] = $message;
};

function redirect_to($path)
{
    header('Location: ' . $path);
    exit();
};

function is_login_in()
{
    if (isset($_SESSION['user'])) {
        return true;
    }

    return false;
};

function is_not_login_in()
{
    return !is_login_in();
};

function is_admin($user)
{
   if ($user['is_admin']){
       return true;
   };

    return false;
};

function is_owner($user)
{
    if ($user['id'] == $_SESSION['user']['id']){
        return true;
    };

    return false;
};

function get_user_by_id($id) {
    $db = new PDO ('mysql:dbname=diplom_v1; host=localhost', 'root', '');

    $query = 'SELECT * from users WHERE id = :id';

    $stmt = $db->prepare($query);

    $stmt->execute([':id' => $id]);

    return  $stmt->fetch(PDO::FETCH_ASSOC);
};

function is_author($logged_user_id, $edit_user_id)
{
    if ($logged_user_id == $edit_user_id)
    {
        return get_user_by_id($edit_user_id);
    };

    return false;
};

function display_flash_message($name)
{
   if (isset($_SESSION[$name]))
   {
       echo "<div class='alert alert-$name text-dark' role='alert'>$_SESSION[$name]</div>";
       unset($_SESSION[$name]);
   };
};