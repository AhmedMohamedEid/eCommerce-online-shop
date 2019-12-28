<?php


	/*
	 * Get All  Function From Database v2.0
	 * Function To Get All Recordes  From Database 
	  
	 */
	
	function  getAllFrom( $field ,  $tablename ,  $where = NULL , $and = NULL , $orderBy , $orderType = "DESC" ) {
		global $conect;
	 
		$getAll = $conect ->prepare( " SELECT $field FROM $tablename $where $and ORDER BY $orderBy $orderType ");
		
		$getAll ->execute();
		
		$All = $getAll-> fetchAll();
		
		return $All ;
	}

	/*
	 * Get Categories Function From Database v1.0
	 * Function To Get Categories  From Database 
	  
	 */
	
	function  getCat() {
		global $conect;
		$getCat = $conect ->prepare( " SELECT * FROM categories ORDER BY Cat_ID ASC  ");
		
		$getCat ->execute();
		
		$cats = $getCat-> fetchAll();
		
		return $cats ;
	}

	/*
	 * Get Ad Items Function From Database v1.0
	 * Function To Get Ad  Items From Database 
	  
	 */
	
	function  getItem($where , $valeu , $approve = NULL) {
		global $conect;
		if($approve == NULL){
			$sql = 'AND Approve = 1';
		}else{
			$sql = NULL;
		}
		$getItem = $conect ->prepare( " SELECT * FROM items  WHERE  $where = ? $sql ORDER BY Item_ID DESC  ");
		
		$getItem ->execute(array($valeu));
		
		$items = $getItem-> fetchAll();
		
		return $items ;
	}

	/*
	 * Check User Status Form Database v1.0
	 * Function Check If User Is Active OR Not Active From Database 
	 */
	function checkUserStatus ($user){
		global $conect;
		
		$stmtx = $conect->prepare("SELECT Username , Regstatus FROM users WHERE Username = ? AND Regstatus = 0");
		
		$stmtx ->execute(array($user));
		
		$status = $stmtx ->rowCount();
		return($status);
	}


	/*check Items Function v1.0
	 * Function To check Items In Database [ Function Accept Parameters ]
	 *  $select =The Items To Select [Example: User , item]
	 *  $from  = The Table To Select From [ Example: users , items ]
	 *  $values = The Value of Select [ Example: Ahmed , box ]
	 */
	function checkItem( $select , $from , $value){
		global $conect;
		$statement = $conect->prepare(" SELECT $select FROM $from WHERE $select = ?");
		
		$statement->execute(array($value));
		
		$count = $statement->rowCount();
		return $count;
	}
	


/*-------------------------------------------------*/
/* Title Function v1.0
 * Title Function That is Echo the Page Title In case The Page Has
 * The Variable $pageTitle And Echo Defult Title From Other Pages
*/

	function getTitle(){
		global $pageTitle;
		if (isset($pageTitle)){
			echo $pageTitle;
		} else{
				echo "Defult";
			}

	}
	
	/* Redirect Function v2.0
	 * Redirect Function [ This Function Accept Paremeters ]
	 * $theMsg = [ Echo The  Message  ] [ Error | Success | Warning ]
	 * $url  = [ The Link yuo Went to Redirect ]
	 * $seconds  = [ Second Before Redirecting ]
	 */
	function redirectPage( $theMsg , $url = null , $seconds = 3 )
	{
		if($url == null){
			$url =  'index.php' ;
			$link = 'Home Page';
		}else{
			if (isset($_SERVER ['HTTP_REFERER'] ) && $_SERVER ['HTTP_REFERER'] !== ''){
				
				$url = $_SERVER ['HTTP_REFERER'];
				$link = 'Previous Page';
			} else{
				$url = 'index.php';
				$link = 'Home Page'; 
			}
		}
		echo $theMsg ;
		echo "<div class='alert alert-info'> You Will Be Redirected to $link After  $seconds Seconds.</div>";
		header("refresh:$seconds; url=$url");
		exit();
	}
	
	
	
	
	/*
	 * Count Number of Items
	 * Function to count number of items rows
	 * $item = The item To Count
	 * $from = The Table To Select From 
	*/
	
	function  countItems( $item , $from   ) {
		 global $conect ;
		 
		 $stmt2 = $conect->prepare(" SELECT COUNT($item) FROM $from  ");
		 
		 $stmt2 ->execute();
		 
		 return $stmt2->fetchColumn();
	}

	
	/*
	 * Get Latest Function From Database v1.0
	 * Function To Get Latest Items From Database [ Users , Items , Comments ]
	 * $select = Field To Select
	 * $table  = The Table To Choose From
	 * $order  = The Desc Ordering
	 * $limit  = Number of Records To get  
	 */
	
	function  getLatest( $select , $table , $order , $limit  ) {
		global $conect;
		$getStmt = $conect ->prepare( " SELECT $select FROM $table ORDER BY $order DESC LIMIT $limit ");
		
		$getStmt ->execute();
		
		$rows = $getStmt-> fetchAll();
		
		return $rows ;
	}
	