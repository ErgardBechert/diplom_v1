<?php
    session_start();

    require 'function.php';

    logout();

    redirect_to('page_login.php');