<?php
    session_start();

    require 'function.php';

    if(is_not_login_in()){
        redirect_to('page_login.php');
    }

    $users = get_users();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
</head>
    <body class="mod-bg-1 mod-nav-link">
        <?php include 'header.php' ?>

        <main id="js-page-content" role="main" class="page-content mt-3">

            <?php display_flash_message('success'); ?>
            <?php display_flash_message('danger'); ?>

            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-users'></i> Список пользователей
                </h1>
            </div>
            <div class="row">
                <div class="col-xl-12">

                    <?php if (is_admin(get_authenticated_user())) : ?>
                        <a class="btn btn-success" href="create_user.php">Добавить</a>
                    <?php endif; ?>

                    <div class="border-faded bg-faded p-3 mb-g d-flex mt-3">
                        <input type="text" id="js-filter-contacts" name="filter-contacts" class="form-control shadow-inset-2 form-control-lg" placeholder="Найти пользователя">
                        <div class="btn-group btn-group-lg btn-group-toggle hidden-lg-down ml-3" data-toggle="buttons">
                            <label class="btn btn-default active">
                                <input type="radio" name="contactview" id="grid" checked="" value="grid"><i class="fas fa-table"></i>
                            </label>
                            <label class="btn btn-default">
                                <input type="radio" name="contactview" id="table" value="table"><i class="fas fa-th-list"></i>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" id="js-contacts">
                <?php foreach($users as $user): ?>
                    <div class="col-xl-4">
                        <div id="c_1" class="card border shadow-0 mb-g shadow-sm-hover" data-filter-tags="oliver kopyov">
                            <div class="card-body border-faded border-top-0 border-left-0 border-right-0 rounded-top">
                                <div class="d-flex flex-row align-items-center">
                                <span class="status <?php get_status_color($user['status_id']) ?> mr-3">

                                     <a href="page_profile.php?id=<?php echo $user['id'] ?>" >
                                          <span class="rounded-circle profile-image d-block "
                                                style="<?php echo "background-image:url('" . has_image($user['id']) . "');"?>
                                                        background-size: cover;">

                                          </span>
                                          </span>
                                     </a>


                                    <div class="info-card-text flex-1">
                                        <a href="javascript:void(0);" class="fs-xl text-truncate text-truncate-lg text-info" data-toggle="dropdown" aria-expanded="false">
                                            <?php echo !empty($user['username']) ? $user['username'] : 'User'?>

                                            <?php if (is_admin(get_authenticated_user()) || is_owner($user)) : ?>
                                                <i class="fal fas fa-cog fa-fw d-inline-block ml-1 fs-md"></i>
                                                <i class="fal fa-angle-down d-inline-block ml-1 fs-md"></i>
                                            <?php endif; ?>
                                        </a>

                                        <?php if (is_admin(get_authenticated_user()) || is_owner($user)) : ?>
                                            <div class="dropdown-menu">
                                            <a class="dropdown-item" href="edit_user.php?id=<?php echo $user['id'] ?>">
                                                <i class="fa fa-edit"></i>
                                                Редактировать</a>
                                            <a class="dropdown-item" href="security.php?id=<?php echo $user['id'] ?>">
                                                <i class="fa fa-lock"></i>
                                                Безопасность</a>
                                            <a class="dropdown-item" href="status.php?id=<?php echo $user['id'] ?>">
                                                <i class="fa fa-sun"></i>
                                                Установить статус</a>
                                            <a class="dropdown-item" href="media.php?id=<?php echo $user['id'] ?>">
                                                <i class="fa fa-camera"></i>
                                                Загрузить аватар
                                            </a>
                                            <a href="delete.php?id=<?php echo $user['id'] ?>" class="dropdown-item" onclick="return confirm('are you sure?');">
                                                <i class="fa fa-window-close"></i>
                                                Удалить
                                            </a>
                                        </div>
                                       <?php endif; ?>

                                        <span class="text-truncate text-truncate-xl"><?php echo $user['job'] ?? ''?></span>
                                    </div>
                                    <button class="js-expand-btn btn btn-sm btn-default d-none" data-toggle="collapse" data-target="#c_1 > .card-body + .card-body" aria-expanded="false">
                                        <span class="collapsed-hidden">+</span>
                                        <span class="collapsed-reveal">-</span>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0 collapse show">
                                <div class="p-3">

                                    <?php if ($user['phone']): ?>
                                        <a href="tel:<?php echo $user['phone'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                            <i class="fas fa-mobile-alt text-muted mr-2"></i>
                                            <?php echo $user['phone'] ?>
                                        </a>
                                    <?php endif; ?>

                                    <?php if ($user['email']): ?>
                                        <a href="mailto:<?php echo $user['email'] ?>" class="mt-1 d-block fs-sm fw-400 text-dark">
                                            <i class="fas fa-mouse-pointer text-muted mr-2"></i>
                                            <?php echo $user['email'] ?>
                                        </a>
                                    <?php endif; ?>


                                    <?php if ($user['address']): ?>
                                        <address class="fs-sm fw-400 mt-4 text-muted">
                                            <i class="fas fa-map-pin mr-2"></i>
                                            <?php echo $user['address'] ?>
                                        </address>
                                    <?php endif; ?>


                                    <div class="d-flex flex-row">
                                        <?php echo $user['vk'] ? '<a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>' : ''?>

                                        <?php echo $user['tg'] ? '<a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#38A1F3">
                                            <i class="fab fa-telegram"></i>
                                        </a>' : ''?>

                                        <?php echo $user['inst'] ? '  <a href="javascript:void(0);" class="mr-2 fs-xxl" style="color:#E1306C">
                                            <i class="fab fa-instagram"></i>
                                        </a>' : ''?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </main>
     
        <!-- BEGIN Page Footer -->
        <footer class="page-footer" role="contentinfo">
            <div class="d-flex align-items-center flex-1 text-muted">
                <span class="hidden-md-down fw-700">2020 © Учебный проект</span>
            </div>
            <div>
                <ul class="list-table m-0">
                    <li><a href="intel_introduction.html" class="text-secondary fw-700">Home</a></li>
                    <li class="pl-3"><a href="info_app_licensing.html" class="text-secondary fw-700">About</a></li>
                </ul>
            </div>
        </footer>
        
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

            $('input[type=radio][name=contactview]').change(function()
                {
                    if (this.value == 'grid')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-g');
                        $('#js-contacts .col-xl-12').removeClassPrefix('col-xl-').addClass('col-xl-4');
                        $('#js-contacts .js-expand-btn').addClass('d-none');
                        $('#js-contacts .card-body + .card-body').addClass('show');

                    }
                    else if (this.value == 'table')
                    {
                        $('#js-contacts .card').removeClassPrefix('mb-').addClass('mb-1');
                        $('#js-contacts .col-xl-4').removeClassPrefix('col-xl-').addClass('col-xl-12');
                        $('#js-contacts .js-expand-btn').removeClass('d-none');
                        $('#js-contacts .card-body + .card-body').removeClass('show');
                    }

                });

                //initialize filter
                initApp.listFilter($('#js-contacts'), $('#js-filter-contacts'));
        });

    </script>
</html>