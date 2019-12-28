<?php
    // Add The conect to Database File
    include 'conect_to_db.php';
    
    
    // Routse
	$tpl = 'include/templates/';  // Director Templates 
	$func = 'include/functions/';  // Director functions
	$lang = 'include/languages/';	// Director languages
	$css = 'layout/css/';			// Director Css fils
	$js  = 'layout/js/'; 			// Director js Fils
	
    
    // Include The Impotant File 
	include $func . 'functions.php';
	include  $lang .'English.php';
    include $tpl . 'header.php';

    // Adding The Navbar For All page without page include $nonavbar
    if (!isset($nonavbar)){include $tpl.'navbar.php';}
    