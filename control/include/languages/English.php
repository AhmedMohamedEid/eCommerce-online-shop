<?php 

function lang($phrase){

	static $lang = array(
		// Navbar Links
		'HOME_ADMIN' 	=> 'Home' ,
		'SECTION'   	=> 'Categories',
		'ITEMS' 		=> 'Items',
		'MEMBERS' 		=> 'Membars',
		'COMMMENTS'		=> 'Comments',
		'STATISTICS'	=> 'Statistics',
		'LOGS' 			=> 'Logs'
		);
	return $lang [$phrase];
}