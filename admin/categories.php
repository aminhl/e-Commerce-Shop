<?php

session_start();
$pageTitle = 'Categories';

if (isset($_SESSION['username'])){
    include_once 'init.php';
    $do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

    if ($do == 'Manage'){
        $sort = 'ASC'; # Default Sorting
        $sort_array = array('asc','desc');
        if (isset($_GET['sort']) && in_array($_GET['sort'],$sort_array)){
            $sort = $_GET['sort'];
        }
        $statement = $con->prepare("SELECT * FROM categories ORDER BY Ordering $sort");
        $statement->execute();
        $cats = $statement->fetchAll(); ?>
        <h1 class="text-center">Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <i class="fa fa-edit"></i> Manage Categories
                    <div class="option pull-right">
                        <i class="fa fa-sort"></i> Ordering : [
                        <a class="<?php if ($sort == 'asc') { echo 'active';} ?>" href="?sort=asc">Asc</a> |
                        <a class="<?php if ($sort == 'desc') { echo 'active';} ?>" href="?sort=desc">Desc</a> ]
                        <i class="fa fa-eye"></i>View : [ <span class="active" data-view="full">Full</span> |
                                <span data-view="classic">Classic</span> ]

                    </div>
                </div>
                <div class="panel-body">
                   <?php
                   foreach ($cats as $cat){
                       echo '<div class="cat">';
                       echo '<div class="hidden-buttons">';
                       echo '<a href="categories.php?do=Edit&catid='. $cat['ID'] . '" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
                       echo '<a href="categories.php?do=Delete&catid=' . $cat['ID'] . '" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>';
                       echo '</div>';
                       echo '<h3>'. $cat['Name'] . '</h3>';
                       echo '<div class="full-view">';
                           echo '<p>'; if ($cat['Description'] == '') {echo 'This Category No Description';} else { echo $cat['Description'];}  echo  '</p>';
                           if ($cat['Visibility'] == 1) {echo '<span class="visibility"><i class="fa fa-eye"></i> Hidden</span>';}
                           if ($cat['Allow_Comment'] == 1) {echo '<span class="commenting"><i class="fa fa-close"></i> Comment Disabled</span>';}
                           if ($cat['Allow_Ads'] == 1) {echo '<span class="advertises"><i class="fa fa-close"></i> Ads Disabled</span>';}
                       echo '</div>';
                       echo '</div>';
                       echo '<hr>';
                   }
                   ?>
                </div>
            </div>
            <a href="categories.php?do=Add" class="add-category btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>
        </div>
    <?php }
    elseif($do == 'Edit'){ ?>
        <?php
        $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  intval($_GET['catid']) : 0;
        $stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");
        $stmt->execute(array($catid));
        $cat = $stmt->fetch();
        $count = $stmt->rowCount();
        if($count > 0){   ?>
            <h1 class="text-center">Edit Category</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="post">
                    <input type="hidden" name="catid" value="<?php echo $cat['ID']?>">
                    <!--Start Name Filed-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Name</label>
                        <div class="col-sm-10 col-md-6">
                            <input class="form-control" type="text" name="name" value="<?php echo $cat['Name']; ?>" required="required">
                        </div>
                    </div>
                    <!--End Name Filed-->
                    <!--Start Description Filed-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Description</label>
                        <div class="col-sm-10 col-md-6">
                            <input class="form-control" type="text" name="description" value="<?php echo $cat['Description']; ?>">
                        </div>
                    </div>
                    <!--End Description Filed-->
                    <!--Start Ordering Filed-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Ordering</label>
                        <div class="col-sm-10 col-md-6">
                            <input class="form-control" type="text"  name="ordering" value="<?php echo $cat['Ordering']; ?>">
                        </div>
                    </div>
                    <!--End Ordering Filed-->
                    <!--Start Visibility Filed-->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Visibility</label>
                        <div class="col-sm-10 col-md-6">
                            <div>
                                <input id="visibility-yes" type="radio" name="visibility" value = "0" <?php if($cat['Visibility'] == 0) { echo 'checked';} ?>>
                                <label for="visibility-yes">Yes</label>
                            </div>
                            <div>
                                <input id="visibility-no" type="radio" name="visibility" value = "1" <?php if($cat['Visibility'] == 1) { echo 'checked';} ?>>
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
                                <input id="commenting-yes" type="radio" name="commenting" value = "0" <?php if($cat['Allow_Comment'] == 0) { echo 'checked';} ?>>
                                <label for="commenting-yes">Yes</label>
                            </div>
                            <div>
                                <input id="commenting-no" type="radio" name="commenting" value = "1" <?php if($cat['Allow_Comment'] == 1) { echo 'checked';} ?>>
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
                                <input id="ads-yes" type="radio" name="ads" value = "0" <?php if($cat['Allow_Ads'] == 0) { echo 'checked';} ?>>
                                <label for="ads-yes">Yes</label>
                            </div>
                            <div>
                                <input id="ads-no" type="radio" name="ads" value = "1" <?php if($cat['Allow_Ads'] == 1) { echo 'checked';} ?>>
                                <label for="ads-no">No</label>
                            </div>
                        </div>
                    </div>
                    <!--End Ads Filed-->
                    <!--Start Submit Filed-->
                    <div class="form-group form-group-lg">
                        <div class="col-sm-offset-2 col-sm-10">
                            <input class="btn btn-primary" type="submit" value="Update">
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
        echo  '<h1 class="text-center">Update Category</h1>';
        echo '<div class="container">';
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            # Get Variables From The Form
            $id = $_POST['catid'];
            $name = $_POST['name'];
            $desc = $_POST['description'];
            $order = $_POST['ordering'];
            $visible = $_POST['visibility'];
            $comment = $_POST['commenting'];
            $ads = $_POST['ads'];


                $stmt = $con->prepare("UPDATE categories SET Name = ? ,Description = ? , Ordering = ? , Visibility = ? , Allow_Comment = ? , Allow_Ads = ?  WHERE ID = ? ");
                $stmt->execute(array($name,$desc,$order,$visible,$comment,$ads,$id));
                $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Record Updated </div>';
                redirectHome($theMsg,'Previous');

        }
        else{
            $theMsg = '<div class="alert alert-danger">U Re Not Authorized To Be Here</div>';
            redirectHome($theMsg);
        }
        echo '</div>';
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
        echo  '<h1 class="text-center">Delete Member</h1>';
        echo '<div class="container">';
        $catid = (isset($_GET['catid']) && is_numeric($_GET['catid'])) ?  intval($_GET['catid']) : 0;
        $check = checkItem('ID','categories',$catid);

        if($check > 0){
            $stmt = $con->prepare("DELETE FROM categories WHERE ID = :catid");
            $stmt->bindParam(":catid",$catid);
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
}


else {
    header('Location: index.php');
    exit();
}