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

# Home Redirect Function : Parameters : $errorMsg => Echo The Error Msg , $seconds = Time Before Redirecting v1.0

function redirectHome ($errorMsg,$seconds =3){
    echo "<div class='alert alert-danger'>$errorMsg</div>";
    echo "<div class='alert alert-info'>You Will Be Redirected  After $seconds Seconds.</div>";
    header("refresh:$seconds;url=index.php");
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

