<?php

function lang( $phrase ){
    static $lang = array(
        # Home Page
        'Message' => 'Welcome In Arabic',
        "Admin" => 'Arabic Admin',
    );
    return $lang[$phrase];
}