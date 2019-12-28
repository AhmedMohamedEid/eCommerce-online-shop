<?php

/*
 *================================
 *==  Page
 *== You Can Add | Delete | Edit 
 *================================
 */
ob_start();

session_start();

$pageTitle = '';

if(isset ($_SESSION['login'])){

    include 'init.php';
    
    
    $do = isset($_GET['do'])?$_GET['do'] : 'Manage';

    
    if($do == 'Manage'){
    // Manage Page
	
	
    }elseif($do == 'Edit'){  // Edit Page
        
    
    }elseif($do == 'Update'){
        // Update Page
    
    }elseif($do == 'Add'){
        // Add Page 
    
    }elseif($do == 'Insert'){
        //Insert Page
        
		
    }elseif($do == 'Delete'){
        // Delete Page
        
        
    }elseif($do == 'Approived'){
        //Approvied Page
		
        
    }else{
        // 
    }
    
    

    include  $tpl . 'footer.php';
}else{
        header('Location:index.php');
        exit();
    }
ob_end_flush();
?>
