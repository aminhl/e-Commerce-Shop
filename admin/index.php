<?php
session_start();
$noNavbar = '';
$pageTitle = 'Login';
if(isset($_SESSION['username'])){
    header('Location: dashboard.php');  # Redirect To Dashboard
}
include 'init.php';


# Check If The User Is Coming From Request
if ($_SERVER['REQUEST_METHOD']=='POST'){
    $username = $_POST['username'];
    $pass = $_POST['pass'];
    $hashedPass = sha1($pass);

# Check If The  User Exist In The Database
    $stmt = $con->prepare("select UserID,UserName,Password FROM users WHERE Username = ? AND Password = ? AND GroupID = 1 LIMIT 1");
    $stmt->execute(array($username,$hashedPass));
    $row = $stmt->fetch();
    $count = $stmt->rowCount();
    if ($count>0)
        $_SESSION['username'] = $username;  # Register Session Name
        $_SESSION['ID'] = $row['UserID'];   # Register Session ID
        header('Location: dashboard.php');
        exit();

}
?>


<form class="form-login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <h4 class="text-center">Admin Login</h4>
    <input class="form-control" type="text" name="username" placeholder="Username" autocomplete="off">
    <input class="form-control" type="password" name="pass" placeholder="Password" autocomplete="new-password">
    <input class="btn btn-primary btn-block" type="submit" value="Login">
</form>


<?php include_once $tpl .'footer.php'; ?>