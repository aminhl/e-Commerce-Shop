<?php

session_start();
session_unset(); # Unset Data
session_destroy(); # Destory Session
header('Location: index.php');
exit();