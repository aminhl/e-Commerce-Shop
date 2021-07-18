<?php

function lang( $phrase ){
    static $lang = array(
        # Home Page
        'Message' => 'Welcome In Arabic',
        "Admin" => 'Arabic Admin',

        # Settings
    );
    return $lang[$phrase];
}