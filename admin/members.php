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
    # Select All User Expect Admins
        $stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 ");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
         <h1 class="text-center">Manage Members</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td>#ID</td>
                        <td>Username</td>
                        <td>Email</td>
                        <td>Full Name</td>
                        <td>Register Date</td>
                        <td>Control</td>
                    </tr>

                  <?php
                  foreach ($rows as $row) {
                      echo '<tr>';
                      echo '<td>' . $row["UserID"] . '</td>';
                      echo '<td> ' . $row["UserName"] . '</td>';
                      echo '<td> ' . $row["Email"] . '</td>';
                      echo '<td> ' . $row["FullName"] . '</td>';
                      echo '<td>' . $row["Date"] . '</td>';
                      echo '<td>   <a href="members.php?do=Edit&userid='. $row["UserID"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="members.php?do=Delete&userid='. $row["UserID"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a></td>';
                      echo '</tr>';
                  }
                  ?>

                </table>
            </div>
           <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"> </i> New Member</a>
        </div>
    <?php }
    elseif ($do == "Add"){ ?>
        <h1 class="text-center">Add Member</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="post">
                <!--Start Username Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Username</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="username" autocomplete="off" required="required" placeholder="Type Your Username">
                    </div>
                </div>
                <!--End Username Filed-->
                <!--Start Password Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Password</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="password form-control" type="password" name="password" autocomplete="new-password"  required="required" placeholder="Type Your Password">
                        <i class="show-pass fa fa-eye fa-2x"></i>
                    </div>
                </div>
                <!--End Password Filed-->
                <!--Start Email Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="email"  name="email" required="required" placeholder="Type Your Email">
                    </div>
                </div>
                <!--End Email Filed-->
                <!--Start Full Name Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Full Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="full" required="required" placeholder="Type Your Full Name">
                    </div>
                </div>
                <!--End Full Name Filed-->
                <!--Start Submit Filed-->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary" type="submit" value="Add Member">
                    </div>
                </div>
                <!--End Submit Field-->
            </form>
        </div>

    <?php }
    elseif($do == 'Insert'){

        if ($_SERVER['REQUEST_METHOD']=='POST'){
            echo  '<h1 class="text-center">Add Member</h1>';
            echo '<div class="container">';
            # Get Variables From The Form
            $user = $_POST['username'];
            $pass = $_POST['password'];
            $email = $_POST['email'];
            $name = $_POST['full'];

            $hashedPass = sha1($_POST['password']);

            # Validation Form
            $formErrors = array();
            if (empty($user)){
                $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>';
            }
            if (strlen($user)<4 || strlen($user)>20){
                $formErrors[] = 'Username Must Be Between<strong> 4 And 20 Characters</strong>';
            }
            if(empty($pass)){
                $formErrors[] = 'Password Can\'t Be <strong>Empty</strong>';
            }
            if(empty($email)){
                $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
            }
            if (empty($name)){
                $formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
            }

            foreach ($formErrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            # Check If There's No Error
            if (empty($formErrors)){

                $check = checkItem('UserName','users',$user);

                if ($check == 1){
                    $theMsg = '<div class="alert alert-danger">This User Already Exist' . '</div>';
                    redirectHome($theMsg,'Previous');
                }

              else{
                  # Insert Data Base
                  $stmt = $con->prepare("INSERT INTO users(UserName,Password,Email,FullName,RegStatus,Date) VALUES(:user, :pass, :email, :name, 1, now())");
                  $stmt->execute(array(
                      'user' => $user,
                      'pass' => $hashedPass,
                      'email' => $email,
                      'name' => $name,
                  ));
                  $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
                  redirectHome($theMsg,'Previous');
              }
            }
        }
        else{
            echo '<div class="container">';
            $theMsg =  '<div class="alert alert-danger">U Can\'t Browse This Page Directly</div>';
            redirectHome($theMsg);
            echo '</div>';
        }
        echo '</div>';
    }
    elseif($do == 'Edit'){ ?>
         <?php
                $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  intval($_GET['userid']) : 0;
                $stmt = $con->prepare("SELECT * FROM users WHERE UserId = $userid LIMIT 1");
                $stmt->execute(array($userid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count > 0){   ?>
                    <div class="container">
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
                    </div>

    <?php } # Count's If
                else {
                    echo '<div class="container">';
                    $theMsg =  '<div class="alert alert-danger">There\'s No Such Id </div>';
                    redirectHome($theMsg);
                    echo '</div>';
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
              $formErrors[] = 'Username Can\'t Be <strong>Empty</strong>';
          }
          if (strlen($user)<4 || strlen($user)>20){
              $formErrors[] = 'Username Must Be Between<strong> 4 And 20 Characters</strong>';
          }
          if(empty($email)){
              $formErrors[] = 'Email Can\'t Be <strong>Empty</strong>';
          }
          if (empty($name)){
              $formErrors[] = 'Full Name Can\'t Be <strong>Empty</strong>';
          }

          foreach ($formErrors as $error){
              echo '<div class="alert alert-danger">' . $error . '</div>';
          }

        # Check If There's No Error
          if (empty($formErrors)){
              # Update Data Base
              $stmt = $con->prepare("UPDATE users SET UserName = ? ,Email = ? , FullName = ? , Password = ? WHERE UserID = ? ");
              $stmt->execute(array($user,$email,$name,$pass,$id));
              $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
              redirectHome($theMsg,'Previous');
          }
      }
      else{
         $theMsg = '<div class="alert alert-danger">U Re Not Authorized To Be Here</div>';
         redirectHome($theMsg);
      }
        echo '</div>';
    }
    elseif ($do == 'Delete'){
        echo  '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
        $userid = (isset($_GET['userid']) && is_numeric($_GET['userid'])) ?  intval($_GET['userid']) : 0;
        $check = checkItem('UserID','users',$userid);

        if($check > 0){
            $stmt = $con->prepare("DELETE FROM users WHERE UserID = :userid");
            $stmt->bindParam(":userid",$userid);
            $stmt->execute();
            $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Deleted </div>';
            redirectHome($theMsg);
        }
        else{
            $theMsg =  '<div class="alert alert-danger">This Id Doesn\'t Exist</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
    }
    include_once $tpl . 'footer.php';
} else {
    header('Location: index.php');
    exit();
}