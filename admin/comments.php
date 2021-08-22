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
                        echo '<td>   <a href="comments.php?do=Edit&comid='. $row["item_id"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="comments.php?do=Delete&comid='.  $row["item_id"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                        if ($row['status']==0){
                            echo '<a href="comments.php?do=Approve&comid='.  $row["item_id"] .'" class="btn btn-info activate"><i class="fa fa-close"></i> Approve</a>';
                        }
                        echo  '</td>';
                        echo '</tr>';
                    }
                    ?>

                </table>
            </div>
        </div>
    <?php }

    elseif ($do == 'Edit'){

    }
    elseif ($do == 'Update'){

    }
    elseif($do == 'Delete'){

    }
    elseif ($do == 'Approve'){

    }
    include_once $tpl . 'footer.php';
}

else{
    header('Location: index.php');
    exit();
}
