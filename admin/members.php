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
                    <form class="form-horizontal" action="?do=Update" method="post">
                        <input type="hidden" name="userid" value="<?php echo $userid;?>">
                        <!--Start Username Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="text" name="username" value="<?php echo $row['UserName']; ?>" autocomplete="off" required="required">
                            </div>
                        </div>
                        <!--End Username Filed-->
                        <!--Start Password Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>">
                                <input class="form-control" type="password" name="newpassword"  autocomplete="new-password" placeholder="Leave Blank If You Wont To Change">
                            </div>
                        </div>
                        <!--End Password Filed-->
                        <!--Start Email Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="email" value="<?php echo $row['Email']; ?>" name="email" required="required">
                            </div>
                        </div>
                        <!--End Email Filed-->
                        <!--Start Full Name Filed-->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input class="form-control" type="text" value="<?php echo $row['FullName']; ?>" name="full" required="required">
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
    elseif ($do == 'Update'){
      echo  '<h1 class="text-center">Update Member</h1>';
      echo '<div class="container">';
      if ($_SERVER['REQUEST_METHOD']=='POST'){
          # Get Variables From The Form
        $id = $_POST['userid'];
        $user = $_POST['username'];
        $email = $_POST['email'];
        $name = $_POST['full'];

        # Password Trick
        $pass = (empty($_POST['newpassword'])) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

        # Validation Form
        $formErrors = array();
        if (empty($user)){
            $formErrors[] = '<div class="alert alert-danger">Username Can\'t Be <strong>Empty</strong></div>';
        }
        if (strlen($user)<4 || strlen($user)>20){
            $formErrors[] = '<div class="alert alert-danger">Username Must Be Between<strong> 4 And 20 Characters</strong></div>';
        }
        if(empty($email)){
            $formErrors[] = '<div class="alert alert-danger">Email Can\'t Be <strong>Empty</strong></div>';
        }
        if (empty($name)){
            $formErrors[] = '<div class="alert alert-danger">Full Name Can\'t Be <strong>Empty</strong></div>';
        }

        foreach ($formErrors as $error){
            echo $error ;
          }

        # Check If There's No Error
          if (empty($formErrors)){
              # Update Data Base
              $stmt = $con->prepare("UPDATE users SET UserName = ? ,Email = ? , FullName = ? , Password = ? WHERE UserID = ? ");
              $stmt->execute(array($user,$email,$name,$pass,$id));
              echo '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
          }
      }
      else{
          echo 'U Re Not Authorized To Be Here';
      }
      echo '</div>';
    }
    include_once $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}