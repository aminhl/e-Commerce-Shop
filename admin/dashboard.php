<?php
session_start();
if(isset($_SESSION['username'])){
  $pageTitle = 'Dashboard';
  include_once 'init.php';
  include_once $tpl .'footer.php';
}
else{
    echo 'You Are Not Authorized To Visit This Page';
    header('Location: index.php');
    exit();
}