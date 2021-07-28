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
         <?php
                $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  intval($_GET['userid']) : 0;
                $stmt = $con->prepare("SELECT * FROM users WHERE UserId = $userid LIMIT 1");
                $stmt->execute(array($userid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count > 0){   ?>
                    <h1 class="text-center">Edit Member</h1>
                    <form class="form-horizontal">
                        <!--Start Username Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="text" name="username" value="<?php echo $row['UserName']; ?>" autocomplete="off ">
                            </div>
                        </div>
                        <!--End Username Filed-->
                        <!--Start Password Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="password" name="password"  autocomplete="new-password">
                            </div>
                        </div>
                        <!--End Password Filed-->
                        <!--Start Email Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="email" value="<?php echo $row['Email']; ?>" name="email">
                            </div>
                        </div>
                        <!--End Email Filed-->
                        <!--Start Full Name Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="text" value="<?php echo $row['FullName']; ?>" name="full">
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

    <?php } # Count's If
                else {
                    echo 'There\'s No Such Id';
                }
    }
    include_once $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}