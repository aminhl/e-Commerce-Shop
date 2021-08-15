<?php

session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])){
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){

    }
    elseif($do == 'Edit'){

    }

    elseif ($do == 'Update'){

    }

    elseif($do == 'Add'){ ?>
        <h1 class="text-center">Add Category</h1>
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="post">
                <!--Start Name Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="name" autocomplete="off" required="required" placeholder="Type Category's Name">
                    </div>
                </div>
                <!--End Name Filed-->
                <!--Start Description Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Description</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text" name="description"  placeholder="Type Category's Description">
                    </div>
                </div>
                <!--End Description Filed-->
                <!--Start Ordering Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Ordering</label>
                    <div class="col-sm-10 col-md-6">
                        <input class="form-control" type="text"  name="ordering"  placeholder="Type Category's Order">
                    </div>
                </div>
                <!--End Ordering Filed-->
                <!--Start Visibility Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Visibility</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="visibility-yes" type="radio" name="visibility" value = "0" checked>
                            <label for="visibility-yes">Yes</label>
                        </div>
                        <div>
                            <input id="visibility-no" type="radio" name="visibility" value = "1" >
                            <label for="visibility-no">No</label>
                        </div>
                    </div>
                </div>
                <!--End Visibility Filed-->
                <!--Start Commenting Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Commenting</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="commenting-yes" type="radio" name="commenting" value = "0" checked>
                            <label for="commenting-yes">Yes</label>
                        </div>
                        <div>
                            <input id="commenting-no" type="radio" name="commenting" value = "1" >
                            <label for="commenting-no">No</label>
                        </div>
                    </div>
                </div>
                <!--End Commenting Filed-->
                <!--Start Ads Filed-->
                <div class="form-group form-group-lg">
                    <label class="col-sm-2 control-label">Allow Ads</label>
                    <div class="col-sm-10 col-md-6">
                        <div>
                            <input id="ads-yes" type="radio" name="ads" value = "0" checked>
                            <label for="ads-yes">Yes</label>
                        </div>
                        <div>
                            <input id="ads-no" type="radio" name="ads" value = "1" >
                            <label for="ads-no">No</label>
                        </div>
                    </div>
                </div>
                <!--End Ads Filed-->
                <!--Start Submit Filed-->
                <div class="form-group form-group-lg">
                    <div class="col-sm-offset-2 col-sm-10">
                        <input class="btn btn-primary" type="submit" value="Add Category">
                    </div>
                </div>
                <!--End Submit Field-->
            </form>
        </div>
    <?php }

    elseif ($do == 'Insert'){
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            echo  '<h1 class="text-center">Insert Member</h1>';
            echo '<div class="container">';
            # Get Variables From The Form
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visibility = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];

            $check = checkItem('Name','categories',$name);

            if ($check == 1){
                $theMsg = '<div class="alert alert-danger">This User Already Exist' . '</div>';
                redirectHome($theMsg,'Previous');
            }

            else{
                # Insert Data Base
                $stmt = $con->prepare("INSERT INTO categories(Name,Description,Ordering,Visibility,Allow_Comment,Allow_Ads) VALUES(:name, :desc, :order, :visi, :comm, :ads)");
                $stmt->execute(array(
                    'name' => $name,
                    'desc' => $desc,
                    'order' => $order,
                    'visi' => $visibility,
                    'comm' => $comment,
                    'ads' => $ads,
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

    elseif($do == 'Delete'){

    }

    include_once $tpl . 'footer.php';
}


else {
    header('Location: index.php');
    exit();
}