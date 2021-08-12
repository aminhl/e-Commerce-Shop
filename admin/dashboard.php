<?php
session_start();
if(isset($_SESSION['username'])){
  $pageTitle = 'Dashboard';
  include_once 'init.php';
    $latestUser = 5;
    $theLatest = getLatest("*","users","UserID",$latestUser);

  ?>
  <!-- Start Dashboard Page-->
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat st-members">Total Members
                    <span><a href="members.php"><?php echo calculateItems("UserID","users")?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-pendings">Pedning Members
                    <span><a href="members.php?page=Pending"><?php echo checkItem("RegStatus","users",0)?></a></span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-items">Total Items
                    <span>1500</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat st-comments">Total Comments
                    <span>3500</span>
                </div>
            </div>
        </div>
    </div>
    <div class="container latest">
        <div class="row">
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-users"> Latest <?php echo $latestUser; ?> Registered Users</i>
                    </div>
                    <div class="panel-body">
                        <ul class="list-unstyled latest-users">
                       <?php    foreach ($theLatest as $user){
                           echo '<li>';
                           echo $user['UserName'];
                           echo '<a href="members.php?do=Edit&userid=' . $user['UserID'] . '">';
                           echo '<span class="btn btn-success pull-right">';
                           echo '<i class="fa fa-edit"></i> Edit';
                           if ($user['RegStatus'] == 0) {
                               echo "<a 
																	href='members.php?do=Activate&userid=" . $user['UserID'] . "' 
																	class='btn btn-info pull-right activate'>
																	<i class='fa fa-check'></i> Activate</a>";
                           }
                           echo '</span>';
                           echo '</a>';
                           echo '</li>';
                                } ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag"> Latest Items</i>
                    </div>
                    <div class="panel-body">Item</div>
                </div>
            </div>
        </div>
    </div>

   <!--End Dashboard Page-->
<?php  include_once $tpl .'footer.php';
}
else{
    echo 'You Are Not Authorized To Visit This Page';
    header('Location: index.php');
    exit();
}