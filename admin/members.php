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
    elseif($do == 'Edit'){ ?>
        <h1 class="text-center">Edit Member</h1>
        <form class="form-horizontal">
            <!--Start Username Filed-->
        <div class="form-group form-group-lg">
          <label class="col-sm-2 control-label">Username</label>
            <div class="col-sm-10 col-md-6">
                <input class="form-control" type="text" name="username" autocomplete="off ">
            </div>
        </div>
            <!--End Username Filed-->
            <!--Start Password Filed-->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10 col-md-6">
                    <input class="form-control" type="password" name="password" autocomplete="new-password">
                </div>
            </div>
            <!--End Password Filed-->
            <!--Start Email Filed-->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10 col-md-6">
                    <input class="form-control" type="email" name="email">
                </div>
            </div>
            <!--End Email Filed-->
            <!--Start Full Name Filed-->
            <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label">Full Name</label>
                <div class="col-sm-10 col-md-6">
                    <input class="form-control" type="text" name="full">
                </div>
            </div>
            <!--End Full Name Filed-->
            <!--Start Submit Filed-->
            <div class="form-group form-group-lg">
                <div class="col-sm-offset-2 col-sm-10">
                    <input class="btn btn-primary" type="submit" value="Save">
                </div>
            </div>
            <!--End Submit Field-->

        </form>
        <div class="container"></div>
    <?php }
    include_once $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}