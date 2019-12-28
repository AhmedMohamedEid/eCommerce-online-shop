 <?php
    $dbc  = 'mysql:host=localhost;dbname=ecommerce';
    $user = 'root';
    $pass = '';
    $option = array(
        PDO::MYSQL_ATTR_INIT_COMMAND =>'SET NAMES utf8' 
    );
    try {
		$conect = new PDO ($dbc , $user, $pass ,$option);
		$conect -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 
	}catch (PDOException $e){
		echo "Failde" . $e->getMessage();
	}