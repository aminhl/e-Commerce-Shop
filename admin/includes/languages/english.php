<?php

function lang( $phrase ){
    static $lang = array(
       'Message' => 'Welcome',
        "Admin" => 'Administrator',
    );
    return $lang[$phrase];
}