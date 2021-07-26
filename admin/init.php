<?php
include_once 'connect.php';

#Routes

$tpl = 'includes/templates/';  # Template Dir
$css = 'layout/'; # CSS Dir
$js = 'layout/'; # JS Dir
$lang = 'includes/languages/'; # Lang Dir

include_once $lang .'english.php';
include_once  $tpl .'header.php';

# Include Navbar On All Pages Expect That has $noNavbar  Variable

if (!isset($noNavbar)){
    include_once  $tpl .'navbar.php';
}