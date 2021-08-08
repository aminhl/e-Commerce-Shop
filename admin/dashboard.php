<?php
session_start();
if(isset($_SESSION['username'])){
  $pageTitle = 'Dashboard';
  include_once 'init.php'; ?>
  <!-- Start Dashboard Page-->
    <div class="container home-stats text-center">
        <h1>Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="stat">Total Members
                    <span>200</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">Pedning Members
                    <span>25</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">Total Items
                    <span>1500</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat">Total Comments
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
                        <i class="fa fa-users">Latest Registered Users</i>
                    </div>
                    <div class="panel-body">User</div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <i class="fa fa-tag">Latest Items</i>
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