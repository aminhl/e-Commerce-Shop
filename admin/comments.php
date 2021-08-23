<?php
session_start();
$pageTitle = 'Comments';

if (isset($_SESSION['username'])){
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){
        $stmt = $con->prepare("SELECT comments.*, items.Name AS Item_Name, users.UserName AS Member FROM comments INNER JOIN items ON items.Item_ID = comments.item_id INNER JOIN users ON users.UserID = comments.user_id");
        $stmt->execute();
        $rows = $stmt->fetchAll();
        ?>
        <h1 class="text-center">Manage Comments</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td>ID</td>
                        <td>Comment</td>
                        <td>Item Name</td>
                        <td>User Name</td>
                        <td>Added Date</td>
                        <td>Control</td>
                    </tr>

                    <?php
                    foreach ($rows as $row) {
                        echo '<tr>';
                        echo '<td>' . $row["c_id"] . '</td>';
                        echo '<td> ' . $row["comment"] . '</td>';
                        echo '<td> ' . $row["Item_Name"] . '</td>';
                        echo '<td> ' . $row["Member"] . '</td>';
                        echo '<td>' . $row["comment_date"] . '</td>';
                        echo '<td>   <a href="comments.php?do=Edit&comid='. $row["c_id"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="comments.php?do=Delete&comid='.  $row["c_id"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                        if ($row['status']==0){
                            echo '<a href="comments.php?do=Approve&comid='.  $row["c_id"] .'" class="btn btn-info activate"><i class="fa fa-close"></i> Approve</a>';
                        }
                        echo  '</td>';
                        echo '</tr>';
                    }
                    ?>

                </table>
            </div>
        </div>
    <?php }

    elseif ($do == 'Edit'){ ?>
        <?php
                $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;
                $stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");
                $stmt->execute(array($comid));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if($count > 0){   ?>
                    <div class="container">
                        <h1 class="text-center">Edit Comment</h1>
                        <form class="form-horizontal" action="?do=Update" method="post">
                            <input type="hidden" name="comid" value="<?php echo $comid;?>">
                            <!--Start Comment Filed-->
                            <div class="form-group form-group-lg">
                                <label class="col-sm-2 control-label">Comment</label>
                                <div class="col-sm-10 col-md-6">
                                   <textarea class="form-control" name="comment"><?php echo $row['comment']; ?></textarea>
                                </div>
                            </div>
                            <!--End Comment Filed-->
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
        echo  '<h1 class="text-center">Update Comment</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            # Get Variables From The Form
            $id = $_POST['comid'];
            $com = $_POST['comment'];

            # Update Data Base
            $stmt = $con->prepare("UPDATE comments SET comment = ?  WHERE c_id = ? ");
            $stmt->execute(array($com,$id));
            $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
            redirectHome($theMsg,'Previous');
        }
        else{
            $theMsg = '<div class="alert alert-danger">U Re Not Authorized To Be Here</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
    }
    elseif($do == 'Delete'){
        echo  '<h1 class="text-center">Delete Comment</h1>';
        echo '<div class="container">';
        $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;
        $check = checkItem('c_id','comments',$comid);

        if($check > 0){
            $stmt = $con->prepare("DELETE FROM comments WHERE c_id = :comid");
            $stmt->bindParam(":comid",$comid);
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
    elseif ($do == 'Approve'){
        echo  '<h1 class="text-center">Approve Comment</h1>';
        echo '<div class="container">';
        $comid = (isset($_GET['comid']) && is_numeric($_GET['comid'])) ?  intval($_GET['comid']) : 0;
        $check = checkItem('c_id','comments',$comid);

        if($check > 0){
            $stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id = ?");
            $stmt->execute(array($comid));
            $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
            redirectHome($theMsg,'Previous');
        }
        else{
            $theMsg =  '<div class="alert alert-danger">This Id Doesn\'t Exist</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
    }
    include_once $tpl . 'footer.php';
}

else{
    header('Location: index.php');
    exit();
}
