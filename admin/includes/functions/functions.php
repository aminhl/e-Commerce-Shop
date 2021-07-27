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

