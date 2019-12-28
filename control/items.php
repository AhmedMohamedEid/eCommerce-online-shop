<?php

/*
 *================================
 *==  Page
 *== You Can Add | Delete | Edit 
 *================================
 */
ob_start();

session_start();

$pageTitle = 'Items';

if(isset ($_SESSION['Admin_login'])){

    include 'init.php';
    $do = isset($_GET['do'])?$_GET['do'] : 'Manage';

    
    if($do == 'Manage'){
    // Manage Page
		
        // Select  All Users Except Admin
			$stmt =$conect->prepare("SELECT
											items.* ,
											categories.Name AS Category_Name ,
											users.Username
										FROM
											items
										INNER JOIN
											categories
										ON
											categories.Cat_ID = items.Cat_ID
										INNER JOIN
											users
										ON
											users.User_ID = items.Member_ID
										ORDER BY Item_ID DESC
											");
			
			//Execute For Statement
			$stmt ->execute();
			
			// Assign  To Variables
			$items =$stmt ->fetchAll();
			?>
			<h1 class="text-center">Manage Item</h1>
		 	<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Image</td>
							<td class="name">Name</td>
							<td class="desc">Description</td>
							<td>Price</td>
							<td>Country</td>
							<td>Date</td>
							<td>Category</td>
							<td>Username</td>
							<td>Control</td>
						</tr>
						<?php 
						foreach($items  as $item ){  // loop Veiw Member From Database
							echo '<tr>';
								echo'<td>' . $item['Item_ID'] . '</td>';
								echo'<td><img src="..\uploaded\itemImg\\' . $item['Image']  . '" alt="Item Image" /></td>';
								echo'<td>' . $item['Name'] . '</td>';
								echo'<td>' . $item['Description'] . '</td>';
								echo'<td>' . $item['Price'] . '</td>';
								echo'<td>' . $item['Country_Made'] . '</td>';
								echo'<td>' . $item['Add_Date'] . '</td>';
								echo'<td>' . $item['Category_Name'] . '</td>';
								echo'<td>' . $item['Username'] . '</td>';
								echo"<td>
										<a href = 'items.php?do=Edit&itemid=". $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href = 'items.php?do=Delete&itemid=". $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
										if($item["Approve"] == 0){
										echo "<a href = 'items.php?do=Approve&itemid=". $item['Item_ID'] . "' class='btn btn-info activate '><i class=' glyphicon glyphicon-ok'></i> Approve</a>";
										}
								echo"</td>"; 
							echo '</tr>';
						}
						
						?>
						
					</table>
				</div>
				<a href="items.php?do=Add" class="btn btn-sm btn-primary"> <i class="fa fa-plus"></i> New Item</a>
				
			</div>
	<?php 
    }elseif($do == 'Add'){
        // Add  Page
        ?>
			<h1 class="text-center">Add A New Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="username" name="name" class="form-control"  required placeholder="Name Of The Item" />
							</div>
						</div>
					<!-- End Name -->
					<!-- Start Description -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control"  required placeholder="Description of Item" />
							</div>
						</div>
					<!-- End Description -->
					<!-- Start Price -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="price" class="form-control"  required placeholder="Price of Item" />
							</div>
						</div>
					<!-- End Price -->
					<!-- Start Country Made -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country_made" class="form-control"  required placeholder="Country Made of Item" />
							</div>
						</div>
					<!-- End Country Made -->
					<!-- Start Status -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="status">
									<option value="0">.....</option>
									<option value="1">New</option>
									<option value="2">Like New</option>
									<option value="3">Used</option>
									<option value="4">Very Old</option>
								</select>
							</div>
						</div>
					<!-- End Status -->
					<!-- Start Member -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="member">
									<option value="0">.....</option>
									<?php
										$allMembers = getAllFrom("*" , "users" , "" ,"" ,"User_ID");
										foreach($allMembers as $user){
											echo "<option value='". $user["User_ID"] ."'>". $user['Username'] ."</option>";
										}
									?>?>
								</select>
							</div>
						</div>
					<!-- End Member -->
					<!-- Start Categories -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Categories</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="categories">
									<option value="0">.....</option>
									<?php
										$allCats = getAllFrom("*" , "Categories" , "WHERE Parent = 0" ,"" ,"Cat_ID");
										foreach($allCats as $cat){
											echo "<option value='". $cat['Cat_ID'] ."'>". $cat['Name'] ."</option>";
											
											$childCats = getAllFrom("*" , "Categories" , "WHERE Parent = {$cat['Cat_ID']}" ,"" ,"Cat_ID");
											foreach($childCats as $child){
												echo "<option value='". $child['Cat_ID'] ."'>---". $child['Name'] ."</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
					<!-- End Categories -->
					<!-- Start Tags  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tag</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="tags" class="form-control"   placeholder="separate Tag with Comma (,)" />
							</div>
						</div>
					<!-- End Tags  -->
					<!-- Start Image for Item  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tag</label>
							<div class="col-sm-10 col-md-6">
								<input type="file" name="itemImage" class="form-control"  />
							</div>
						</div>
					<!-- End Image for Item -->
					<!-- Start Submit -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Item" class="btn btn-danger btn-md">
							</div>
						</div>
					<!-- End Submit -->
					</form>	
				</div>
		<?php 
    
    }elseif($do == 'Insert'){
        // Insert Page
        
	 	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo "<h1 class='text-center'>Insert Item</h1>";
			echo "<div class='container'>";
			
			// Upload Variable
			//$imgName = $_FILES['itemImage']
			
			$imgName 	=  $_FILES['itemImage']['name'];
			$imgSize 	=  $_FILES['itemImage']['size'];
			$imgTmpName =  $_FILES['itemImage']['tmp_name'];
			$imgtype 	=  $_FILES['itemImage']['type'];
			
			// List Extension File allowed To Upload
			$imgAlloweExtesion = array("png" , "jpeg" , "jpg" ,"gif");
			
			// Get Extesion
			$imgExtestion = explode('.' , $imgName);
			$extension = strtolower(end($imgExtestion));
			
	 		// Get Variables from the form
			
	 		$name 			= $_POST['name'];
	 		$description 	= $_POST['description'];
	 		$price			= $_POST['price'];
			$country 		= $_POST['country_made'];
	 		$status 		= $_POST['status'];
			$member			= $_POST['member'];
			$cat 			= $_POST['categories'];
			$tags 			= $_POST['tags'];
			
	 		// Validate Form 
	 		$formErrors = array();
			
	 		if (empty($name)) {
	 			$formErrors[] ='Name Can\'t be<strong> Empty</strong>';
	 		}
			if (empty($description)){
				$formErrors[] = 'Description Can\'t be<strong> Empty</strong>';
			}
			if (empty($price)) {
	 			$formErrors[] ='Price Can\'t be<strong> Empty</strong>'; 
	 		}
			if (empty($country)) {
	 			$formErrors[] ='Country Can\'t be<strong> Empty</strong>'; 
	 		}
	 		if ($status == 0) {
	 			$formErrors[] ='You Must Select<strong> Status</strong>'; 
	 		}
			if ($member == 0) {
	 			$formErrors[] ='You Must Select<strong> Member</strong>'; 
	 		}
			if ($cat == 0) {
	 			$formErrors[] ='You Must Select<strong> Category</strong>'; 
	 		}
			
			if(empty($imgName)){
				$formErrors[] ='The Image is <strong>Reqiurd</strong>'; 
			}
			if(!empty($imgName) && !in_array($extension , $imgAlloweExtesion)){
				$formErrors[] ='The Extension is Not <strong>Allowed</strong>The Extesion allowed is .Png  .jpeg  .jpg .gif';
			}
			if($imgSize > 4109304){
					$formErrors[] ='The Image Size is larger than <strong>4 MB</strong>'; 
				}
			// Loop Into Errors Array And Echo It 
	 		foreach ($formErrors as $error) {
	 			echo '<div class="alert alert-danger">' . $error . '</div>' ;
	 		}
			// Check if There is no database proceed the Insert Operation ----*****
			
			if (empty($formErrors)){
				// Move File From Your Dir To The Page Dir
				$images = rand(0 , 1000000). '_'. $imgName;
				// Check on Dir Name Is Found or Not Found and Creat it
				$dirName = "..\uploaded\itemImg" ;
				if(! is_dir($dirName)){
					mkdir($dirName); // Make Dir
				}else{
					move_uploaded_file($imgTmpName , $dirName."\\".$images );
				}
				// Insert User Info In Database
				$stmt = $conect->prepare( " INSERT INTO   items( Name, Description , Price, Country_Made , Image ,Status , Add_Date , Cat_ID , Member_ID , Tags)
											VALUES (  :name ,:desc  , :price , :country , :image , :status , now() , :cat , :member , :tags)");
				$stmt->execute(array( 
						'name'		=> $name,
						'desc' 		=> $description,
						'price' 	=> $price,
						'country'	=> $country,
						'image'		=> $imgName,
						'status'	=> $status,
						'cat'		=> $cat,
						'member'	=> $member,
						'tags'		=> $tags
				));
				
				//echo Sucess Message
				$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Item  Inserted</div>';
				redirectPage($theMsg , 'back');  // Back Page to HTTP_REFERER After 3s
				
			}
				echo "</div>";
	 	}else{
				echo '<div class="container">';
				$errorMsg = '<div class= "alert alert-danger">Sorry You cant Browse this Page Directy</div>';
				redirectPage($errorMsg );
				echo '</div>';
			}
			//End Insert Page 
		
    
    }elseif($do == 'Edit'){
        // Edit Page 
		 // Check If get Request Method  Item_ID Is Numeric & get the Integer Value Of It 
	 	$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0 ; #Short Code  If condtion
		// Select All Data Depend On this ID
		 $stmt = $conect->prepare('SELECT * FROM items WHERE Item_ID = ?');
		//Execut Query 
		$stmt->execute(array($itemid));
		// Fetch The Data 
		$items = $stmt->fetch();
		// Row Count 
		$count = $stmt-> rowCount();
		// If There Is Such ID Show The Form 
		if ( $count > 0){ ?>
		
			<h1 class="text-center">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="itemid" value="<?php echo $itemid ?>">
					<!-- Start Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="username" name="name" class="form-control"  required value="<?php echo $items["Name"]; ?>" />
							</div>
						</div>
					<!-- End Name -->
					<!-- Start Description -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control"  required value="<?php echo $items["Description"]; ?>" />
							</div>
						</div>
					<!-- End Description -->
					<!-- Start Price -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="price" class="form-control"  required value="<?php echo $items["Price"]; ?>" />
							</div>
						</div>
					<!-- End Price -->
					<!-- Start Country Made -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Country</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country_made" class="form-control"  required value="<?php echo $items["Country_Made"]; ?>" />
							</div>
						</div>
					<!-- End Country Made -->
					<!-- Start Status -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Status</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="status">
									<option value="1" <?php if($items['Status'] == 1 ){ echo"selected" ;}?> >New</option>
									<option value="2" <?php if($items['Status'] == 2 ){ echo"selected" ;}?> >Like New</option>
									<option value="3" <?php if($items['Status'] == 3 ){ echo"selected" ;}?> >Used</option>
									<option value="4" <?php if($items['Status'] == 4 ){ echo"selected" ;} ?> >Very Old</option>
								</select>
							</div>
						</div>
					<!-- End Status -->
					<!-- Start Member -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Member</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="member">
									<?php
										$allMembers = getAllFrom("*" , "users" , "" ,"" ,"User_ID");
										foreach($allMembers as $user){
											echo "<option value='". $user["User_ID"] ."'";
												 if($items['Member_ID'] == $user["User_ID"] ){ echo"selected" ;} 
											echo">". $user['Username'] ."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!-- End Member -->
					<!-- Start Categories -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Categories</label>
							<div class="col-sm-10 col-md-6">
								<select class="form-control" name="categories">
									<?php
										$allCats = getAllFrom("*" , "Categories" , "WHERE Parent = 0" ,"" ,"Cat_ID");
										foreach($allCats as $cat){
											echo "<option value='". $cat['Cat_ID'] ."'";
												 if($items['Cat_ID'] == $cat['Cat_ID']){ echo"selected" ;} 
											echo">". $cat['Name'] ."</option>";
											
											$childCats = getAllFrom("*" , "Categories" , "WHERE Parent = {$cat['Cat_ID']}" ,"" ,"Cat_ID");
											foreach($childCats as $child){
												echo "<option value='". $child['Cat_ID'] ."'";
												 if($items['Cat_ID'] == $child['Cat_ID']){ echo"selected" ;} 
												echo">---". $child['Name'] ."</option>";
											}
										}
									?>
								</select>
							</div>
						</div>
					<!-- End Categories -->
					<!-- Start Tags  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tag</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="tags" class="form-control"   placeholder="separate Tag with Comma (,)" value="<?php echo $items["Tags"]; ?>" />
							</div>
						</div>
					<!-- End Tags  -->
					<!-- Start Image for Item  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Tag</label>
							<div class="col-sm-10 col-md-6">
								<input type="file" name="itemImage" class="form-control"  />
							</div>
						</div>
					<!-- End Image for Item -->
					<!-- Start Submit -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save Item" class="btn btn-danger btn-md">
							</div>
						</div>
					<!-- End Submit -->
					</form>
					<?php
							// Select  All Users Except Admin
					$stmt =$conect->prepare("SELECT
												comments.* , users.Username AS User_comment
											FROM
												comments
											INNER JOIN
												users
											ON
												users.User_ID = comments.User_ID
											WHERE Item_ID = ?
											");
					
					//Execute For Statement
					$stmt ->execute(array($itemid));
					
					// Assign  To Variables
					$coms =$stmt ->fetchAll();
					 if(! empty($coms)){ ?>
					<h1 class="text-center">Manage <?= $items['Name'] ?> Comments</h1>
					<div class="table-responsive">
						<table class="main-table text-center table table-bordered">
							<tr>
								<td>Commet</td>
								<td>User Name</td>
								<td>Added Date</td>
								<td>Control</td>
							</tr>
							<?php 
							foreach($coms  as $com ){  // loop Veiw Member From Database
								echo '<tr>';
									echo'<td>' . $com['Comment'] . '</td>';
									echo'<td>' . $com['User_comment'] . '</td>';
									echo'<td>' . $com['Comment_Date'] . '</td>';
									echo"<td>
											<a href = 'comments.php?do=Edit&comid=". $com['C_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
											<a href = 'comments.php?do=Delete&comid=". $com['C_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
										if($com['Status'] == 0){
											echo "<a href = 'comments.php?do=Approve&comid=". $com['C_ID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Activated</a>";
	
										}
									echo"</td>"; 
								echo '</tr>';
							}
							
							?>
							
						</table>
					</div>
					<?php }else {
							echo "<span class='alert alert-danger msg'>Not Found Comments</span>";
						}
					?>
				</div>
			<?php
		}else{
			echo "<div class='container'>";
				$ErrorMsg  = '<div class="alert alert-danger">There is Not Such ID</div>';
				redirectPage($ErrorMsg );
			echo "</div>";
        }
    }elseif($do == 'Update'){
        //Insert Page
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
		   echo "<h1 class='text-center'>Update Item</h1>";
		   echo "<div class='container'>";
		   // Get Variables Upload
		   $imgName 	= $_FILES['itemImage']['name'] ;
		   $imgTmpName 	= $_FILES['itemImage']['tmp_name'] ;
		   $imgSize 	= $_FILES['itemImage']['size'] ;
		   $imgType	 	= $_FILES['itemImage']['type'] ;
		   // Filtering For File Type
		   $imageAllowedExtension = array("png", "jpeg" , "jpg", "gif");
		   
		   $imgExtestion = explode("." , $imgName);
		   $extension = strtolower(end($imgExtestion));
		   
		   // Ger Variables from the form
			$id				= $_POST['itemid'];
	 		$name 			= $_POST['name'];
	 		$description 	= $_POST['description'];
	 		$price			= $_POST['price'];
			$country 		= $_POST['country_made'];
	 		$status 		= $_POST['status'];
			$member			= $_POST['member'];
			$cat 			= $_POST['categories'];
			$tags			= $_POST['tags'];
			
	 		// Validate Form 
	 		$formErrors = array();
			
	 		if (empty($name)) {
	 			$formErrors[] ='Name Can\'t be<strong> Empty</strong>';
	 		}
			if (empty($description)){
				$formErrors[] = 'Description Can\'t be<strong> Empty</strong>';
			}
			if (empty($price)) {
	 			$formErrors[] ='Price Can\'t be<strong> Empty</strong>'; 
	 		}
			if (empty($country)) {
	 			$formErrors[] ='Country Can\'t be<strong> Empty</strong>'; 
	 		}
	 		if ($status == 0) {
	 			$formErrors[] ='You Must Select<strong> Status</strong>'; 
	 		}
			if ($member == 0) {
	 			$formErrors[] ='You Must Select<strong> Member</strong>'; 
	 		}
			if ($cat == 0) {
	 			$formErrors[] ='You Must Select<strong> Category</strong>'; 
	 		}
			
			if (empty($imgName)) {
	 			$formErrors[] ='The Image is <strong>Reqiurd</strong>'; 
	 		}
			if (! empty($imgName) && ! in_array($extension , $imageAllowedExtension) ) {
	 			$formErrors[] ='The Extension is Not <strong>Allowed</strong>The Extesion allowed is .Png  .jpeg  .jpg .gif';
	 		}
			if ($imgSize > 4190208) {
	 			$formErrors[] ='The Image Size is larger than <strong>4MB</strong>'; 
	 		}
			// Loop Into Errors Array And Echo It 
	 		foreach ($formErrors as $error) {
	 			echo '<div class="alert alert-danger">' . $error . '</div>' ;
	 		}
			// Check if There is no database proceed the Insert Operation ----*****
			
			if (empty($formErrors)){
				
				$itemImgName  = rand(0 , 1000000). "_" . $imgName;
				
				$dirName = "..\uploaded\itemImg";
				if(! is_dir($dirName)){
					mkdir ($dirName) ;
				}else{
					move_uploaded_file($imgTmpName , $dirName."\\".$itemImgName);
				}
				
				// Update The Data Name With Info
			   $stmt = $conect -> prepare('UPDATE items SET Name =? , Description =? , Price =? , Country_Made =?, Image = ? , Status =? , Member_ID = ? , Cat_ID = ? , Tags = ?  WHERE Item_ID =? ');
			   $stmt->execute(array($name ,$description , $price ,$country , $itemImgName , $status , $member , $cat , $tags ,$id  ));
			   //echo Success Message
			   
			  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Updated</div>';
				redirectPage($theMsg, 'back');
			   
			}else{
				$theMsg = "<div class='alert alert-danger'>Error</div>";
				redirectPage($theMsg, 'back', 5);
			}
		}else{
			echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>Sorry You can\'t Browse this Page Directy </div>";
				redirectPage($theMsg);
			echo '</div>';
	   }
	   echo "</div>";
		
    }elseif($do == 'Delete'){
        // Delete Page
        	 	
		echo "<h1 class='text-center'>Delete Item</h1>";
		echo "<div class='container'>";
		
			// Check If get Request Method  UserID Is Numeric & get the Integer Value Of It 
			$itemid = isset($_GET['itemid'])&& is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0 ; #Short  If condtion
			// Select All Data Depend On this ID
						//$stmt = $conect->prepare('SELECT * FROM users WHERE UserID = ?  LIMIT 1');
			$check = checkItem( 'Item_ID' , 'items' , $itemid);   // Function From Function File Name CheckItem 
							/*//Execut Query 
							   //$stmt->execute(array($userid));
							   // Row Count 
								*/		//$count = $stmt-> rowCount();
			// If There Is Such ID Show The Form 
			if ( $check > 0){
				// Delete Member From Datatbase
				$stmt = $conect->prepare("DELETE FROM items WHERE Item_ID = :xitem");
				$stmt->bindParam(':xitem', $itemid);
				$stmt->execute();
				// Echo Success Message
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Delete</div>';
				redirectPage($theMsg , 'back' );
					
			}else{
				$theMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
				redirectPage($theMsg );
			}
		echo "</div>";
        
    }elseif($do == 'Approve'){
        //Approvied Page
		echo "<h1 class='text-center'>Approived Member</h1>";
		echo "<div class='container'>";
			// Check If Thes Item is Exist in the Database Or No
			$itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']) : 0;
			$check = checkItem('Item_ID' , 'items', $itemid);
			if($check > 0 ){
				$stmt = $conect ->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ? ");
				$stmt->execute(array($itemid));
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Approved</div>';
				redirectPage($theMsg , 'back' );
			}else{
				$errorMsg = '<div class="alert alert-danger">This ID is Not Exist</div>';
				redirectPage($errorMsg);
			}
        echo '</div>';
    }
    
    include  $tpl . 'footer.php';
}else{
        header('Location:index.php');
        exit();
    }
ob_end_flush();
?>
