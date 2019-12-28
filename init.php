<?php
    
	ini_set('display_errors' , 'On');
	error_reporting(E_ALL);
	
	// Add The conect to Database File
    include 'conect_to_db.php';

    	$sessionUser = '';
	if(isset($_SESSION['Login'])){
		$sessionUser = $_SESSION['Login'];
	}
    
	
    // Routse
	$tpl 		= 'include/templates/';  	// Director Templates 
	$func 		= 'include/functions/';  	// Director functions
	$lang 		= 'include/languages/';		// Director languages
	$css 		= 'layout/css/';			// Director Css fils
	$js  		= 'layout/js/'; 			// Director js Fils
	$imglayout  = 'layout/images/'; 		// Director img Files
	$imgItem    = 'uploaded/itemImg/'; 		// Director img Files
	$page 		= 'frontend/';				// Director page Files
	
	
    
    // Include The Impotant File 
	include $func . 'functions.php';
	include $lang .'English.php';
    include $tpl . 'header.php';
	include $tpl . 'navbar.php';


    