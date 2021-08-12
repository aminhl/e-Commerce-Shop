<?php

# Title Function that Echo The Page's Title In Case The Page Has The Variable $pageTitle && Echo Default For Other Pages v1.0

function getTitle(){
    global $pageTitle;
    if (isset($pageTitle)){
        echo $pageTitle;
    }
    else{
        echo 'Default';
    }
}

# Home Redirect Function : Parameters : $errorMsg => Echo The Error Msg , $seconds => Time Before Redirecting v1.0
# Home Redirect Function : Parameters : $theMsg  => Echo The Msg , $url => Link That Will Redirect To , $seconds => Time Before Redirecting v2.0

function redirectHome ($errorMsg,$url = null ,$seconds = 3){
    if ($url === null){
        $url = 'index.php';
        $link = 'HomePage';
    }
    else{
        $url =  (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']!= '') ? $_SERVER['HTTP_REFERER'] : 'index.php';
        $link = 'Previous Page';
    }
    echo $errorMsg;
    echo "<div class='alert alert-info'>You Will Be Redirected To $link After $seconds Seconds.</div>";
    header("refresh:$seconds,url=$url");
    exit();
}

# Function To Check Item In DataBase v1.0 : Parameters :
# $select : The Item To Select [ example: User,Item,Catgeory ... ]
# $from : The Table To Select From
# $value : The Select's Value

function checkItem($select,$from,$value){
    global $con;
    $statement =  $con->prepare("SELECT $select FROM $from WHERE $select = ? ");
    $statement->execute(array($value));
    $count = $statement->rowCount();
    return $count;
}

# Function To Calculate Items In DataBase v1.0
# $item : Item To Count
# $table : Table To Choose From
function calculateItems($item,$table){
    global $con;
    $stmt2 = $con->prepare('SELECT COUNT(UserID) FROM users');
    $stmt2->execute();
    return $stmt2->fetchColumn();
}


