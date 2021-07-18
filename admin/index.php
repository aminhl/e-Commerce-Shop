<?php
include 'init.php';
include_once  $tpl .'header.php';
include_once 'includes/languages/english.php';

# Check If The User Is Coming From Request
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $hashedPass = sha1($pass);

# Check If The  User Exist In The Database
    $stmt = $con->prepare("select UserName,Password FROM users WHERE Username = ? AND Password = ? ");
    $stmt->execute(array($username,$hashedPass));
    $count = $stmt->rowCount();
    if ($count>0)
        echo 'Welcome ' . $username;
}


?>


<form class="form-login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="Login">
</form>


<?php include_once $tpl .'footer.php'; ?>