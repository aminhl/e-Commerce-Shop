<?php

/*
 ================================================
 == Manage Members Page
 == You Can Add | Edit | Edit Members From Here
 ================================================
 */


session_start();
$pageTitle = 'Members';

if (isset($_SESSION['username'])) {
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
    # Start Manage Page
    if($do == 'Manage'){

    }
    elseif($do == 'Edit'){
    echo 'Welcome To Edit Page';
    }
    include_once $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}