<?php
    session_start();

    require 'function.php';

    if (is_not_login_in())
    {
        redirect_to('page_login.php');
    }

    $user_id = $_GET['id'];

    $user = get_user_by_id($user_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Профиль пользователя</title>
    <meta name="description" content="Chartist.html">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
    <link id="vendorsbundle" rel="stylesheet" media="screen, print" href="css/vendors.bundle.css">
    <link id="appbundle" rel="stylesheet" media="screen, print" href="css/app.bundle.css">
    <link id="myskin" rel="stylesheet" media="screen, print" href="css/skins/skin-master.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-solid.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-brands.css">
    <link rel="stylesheet" media="screen, print" href="css/fa-regular.css">
</head>
    <body class="mod-bg-1 mod-nav-link">
        <?php include 'header.php' ?>

        <main id="js-page-content" role="main" class="page-content mt-3">
            <div class="subheader">
                <h1 class="subheader-title">
                    <i class='subheader-icon fal fa-user'></i>    <?php echo !empty($user['username']) ? $user['username'] : 'User'?>
                </h1>

                <?php display_flash_message('success'); ?>
            </div>
            <div class="row">
              <div class="col-lg-6 col-xl-6 m-auto">
                    <!-- profile summary -->
                    <div class="card mb-g rounded-top">
                        <div class="row no-gutters row-grid">
                            <div class="col-12">
                                <div class="d-flex flex-column align-items-center justify-content-center p-4">

                                    <span class="status <?php get_status_color($user['status_id']) ?>">

                                    <span class="rounded-circle profile-image d-block "
                                          style="<?php echo "background-image:url('" . has_image($user['id']) . "');"?>
                                                  background-size: cover; width: 100px; height: 100px">

                                          </span>
                                    </span>
                                    <h5 class="mb-0 fw-700 text-center mt-3">
                                        <?php echo !empty($user['username']) ? $user['username'] : 'User'?>
                                        <?php if ($user['job']): ?>
                                            <small class="text-muted mb-0"><?php echo $user['job'] ?></small>
                                        <?php endif; ?>
                                    </h5>
                                    <div class="mt-4 text-center demo">
                                        <?php echo $user['vk'] ? '<a href="javascript:void(0);" class="mr-2 fs-xl" style="color:#4680C2">
                                            <i class="fab fa-vk"></i>
                                        </a>' : ''?>

                                        <?php echo $user['tg'] ? '<a href="javascript:void(0);" class="mr-2 fs-xl" style="color:#38A1F3">
                                            <i class="fab fa-telegram"></i>
                                        </a>' : ''?>

                                        <?php echo $user['inst'] ? '  <a href="javascript:void(0);" class="mr-2 fs-xl" style="color:#E1306C">
                                            <i class="fab fa-instagram"></i>
                                        </a>' : ''?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="p-3 text-center">

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
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </main>
    </body>

    <script src="js/vendors.bundle.js"></script>
    <script src="js/app.bundle.js"></script>
    <script>

        $(document).ready(function()
        {

        });

    </script>
</html>