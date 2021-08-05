<?php

# Title Function that Echo The Page's Title In Case The Page Has The Variable $pageTitle && Echo Default For Other Pages

function getTitle(){
    global $pageTitle;
    if (isset($pageTitle)){
        echo $pageTitle;
    }
    else{
        echo 'Default';
    }
}

# Home Redirect Function : Parameters : $errorMsg => Echo The Error Msg , $seconds = Time Before Redirecting

function redirectHome ($errorMsg,$seconds =3){
    echo "<div class='alert alert-danger'>$errorMsg</div>";
    echo "<div class='alert alert-info'>You Will Be Redirected  After $seconds Seconds.</div>";
    header("refresh:$seconds;url=index.php");
    exit();
}