<?php

session_start();
$pageTitle = 'Items';
if (isset($_SESSION['username'])){
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){
        echo 'Manage Items Page';
    }
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
                        <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="Type Item's Name">
                    </div>
                </div>
                <!--End Name Filed-->
                <!--Start Description Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="description" autocomplete="off" required="required" placeholder="Type Item's Description">
                    </div>
                </div>
                <!--End Description Filed-->
                <!--Start Price Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="price" autocomplete="off" required="required" placeholder="Type Item's Price">
                    </div>
                </div>
                <!--End Price Field -->
                <!--Start Country Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Country</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="country" autocomplete="off" required="required" placeholder="Type Item's Country">
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