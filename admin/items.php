<?php

session_start();
$pageTitle = 'Items';
if (isset($_SESSION['username'])){
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){

        # Select All User Expect Admins
        $stmt = $con->prepare("SELECT * FROM items");
        $stmt->execute();
        $items = $stmt->fetchAll();
        ?>
        <h1 class="text-center">Manage Items</h1>
        <div class="container">
            <div class="table-responsive">
                <table class="main-table table table-bordered text-center">
                    <tr>
                        <td>ID</td>
                        <td>Name</td>
                        <td>Description</td>
                        <td>Price</td>
                        <td>Adding Date</td>
                        <td>Control</td>
                    </tr>

                    <?php
                    foreach ($items as $item) {
                        echo '<tr>';
                        echo '<td>' . $item["Item_ID"] . '</td>';
                        echo '<td> ' . $item["Name"] . '</td>';
                        echo '<td> ' . $item["Description"] . '</td>';
                        echo '<td> ' . $item["Price"] . '</td>';
                        echo '<td>' . $item["Add_Date"] . '</td>';
                        echo '<td>   <a href="members.php?do=Edit&itemid='. $item["Item_ID"] .'" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a> <a href="members.php?do=Delete&userid='. $item["Item_ID"] .'" class="btn btn-danger confirm"><i class="fa fa-close"></i> Delete</a>';
                        echo  '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
            </div>
            <a href="?do=Add" class="btn btn-primary"><i class="fa fa-plus"> </i> New Item</a>
        </div>
    <?php }
    elseif ($do == 'Edit'){

    }
    elseif ($do == 'Update'){

    }
    elseif ($do == 'Add'){ ?>
        <h1 class="text-center">Add Item</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="post">
                <!--Start Name Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="name" autocomplete="off" placeholder="Type Item's Name">
                    </div>
                </div>
                <!--End Name Filed-->
                <!--Start Description Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="description" autocomplete="off" placeholder="Type Item's Description">
                    </div>
                </div>
                <!--End Description Filed-->
                <!--Start Price Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="price" autocomplete="off" placeholder="Type Item's Price">
                    </div>
                </div>
                <!--End Price Field -->
                <!--Start Country Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="country" autocomplete="off" placeholder="Type Item's Country">
                    </div>
                </div>
                <!--End Country -->
                <!--Start Status Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Status</label>
                    <div class="col-sm-10 col-md-6">
                       <select name="status">
                           <option value="0" >...</option>
                            <option value="1">New</option>
                           <option value="1">Like New</option>
                           <option value="1">Used</option>
                           <option value="1">Old</option>
                       </select>
                    </div>
                </div>
                <!--End Status Field -->
                <!--Start Members Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Members</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="member">
                            <option value="0" >...</option>
                            <?php
                                $stmt = $con->prepare("SELECT * FROM users ");
                                $stmt->execute();
                                $users = $stmt->fetchAll();
                                foreach ($users as $user){
                                    echo "<option value = '" . $user['UserID'] . "'>" .  $user['UserName'] . "</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <!--End Members Field -->
                <!--Start Categories Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Categories</label>
                    <div class="col-sm-10 col-md-6">
                        <select name="category">
                            <option value="0" >...</option>
                            <?php
                            $stmt2 = $con->prepare("SELECT * FROM categories ");
                            $stmt2->execute();
                            $cats = $stmt2->fetchAll();
                            foreach ($cats as $cat){
                                echo "<option value = '" . $cat['ID'] . "'>" .  $cat['Name'] . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!--End Categories Field -->
                <!--Start Submit Filed-->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary" type="submit" value="Add Item">
                    </div>
                </div>
                <!--End Submit Field-->
            </form>
        </div>
   <?php }
    elseif ($do == 'Insert'){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            echo  '<h1 class="text-center">Add Member</h1>';
            echo '<div class="container">';
            # Get Variables From The Form
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $price = $_POST['price'];
            $country = $_POST['country'];
            $status = $_POST['status'];
            $member = $_POST['member'];
            $category = $_POST['category'];

            # Validation Form
            $formErrors = array();
            if (empty($name)){
                $formErrors[] = 'Name Can\'t Be <strong>Empty</strong>';
            }
            if (empty($desc)) {
                $formErrors[] = 'Description Can\'t Be <strong>Empty</strong>';
            }
            if(empty($price)){
                $formErrors[] = 'Price Can\'t Be <strong>Empty</strong>';
            }
            if(empty($country)){
                $formErrors[] = 'Country Can\'t Be <strong>Empty</strong>';
            }
            if($status == 0){
                $formErrors[] = 'Status Can\'t Be <strong>0</strong>';
            }
            if($member == 0){
                $formErrors[] = 'Member Can\'t Be <strong>Empty</strong>';
            }
            if($category == 0){
                $formErrors[] = 'Category Can\'t Be <strong>Empty</strong>';
            }

            foreach ($formErrors as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }

            # Check If There's No Error
            if (empty($formErrors)){

            # Insert Data Base
            $stmt = $con->prepare("INSERT INTO items(Name,Description,Price,Country,Status,Add_Date,Cat_ID,Member_ID) VALUES(:name, :desc, :price, :country, :status, now(),:categ,:memb)");
            $stmt->execute(array(
                'name' => $name,
                'desc' => $desc,
                'price' => $price,
                'country' => $country,
                'status' => $status,
                'categ' => $category,
                'memb' => $member,
            ));
            $theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Inserted </div>';
            redirectHome($theMsg,'Previous');

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
    elseif ($do == 'Delete'){

    }
    elseif ($do == 'Approve'){

    }

    include_once $tpl . 'footer.php';
}


else {
    header('Location: index.php');
    exit();
}