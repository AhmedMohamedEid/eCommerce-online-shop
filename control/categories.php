
<?php

/*
 *================================
 *==  Page
 *== You Can Add | Delete | Edit 
 *================================
 */
ob_start();

session_start();

$pageTitle = 'Categories';

if(isset ($_SESSION['Admin_login'])){

    include 'init.php';
    
    $do = isset($_GET['do'])?$_GET['do'] : 'Manage';
    
	
	
    if($do == 'Manage'){
    // Manage Page
		$sort  = 'ASC';
		$sort_array = array('ASC' , 'DESC');
		if ( isset($_GET['sort']) && in_array($_GET['sort'] , $sort_array)){
			$sort = $_GET['sort'] ;
		}
        $stmt2 = $conect->prepare( " SELECT * FROM categories WHERE Parent = 0 ORDER BY Ordering $sort" );
        $stmt2 ->execute();
        $cats = $stmt2->fetchAll(); ?>
        
        <h1 class="text-center"> Manage Categories</h1>
        <div class="container categories">
            <div class="panel panel-default">
                <div class="panel-heading">
					<i class="fa fa-edit"></i> Manage Categories
					<div class="option pull-right">
						<i class="fa fa-sort"></i> Ordering: [ 
						<a class="<?php  if($sort == 'ASC'){ echo 'active'; } ?> "  href="?sort=ASC" >Asc</a> |
						<a class="<?php  if($sort == 'DESC'){ echo 'active'; } ?> "  href="?sort=DESC">Desc</a> ]
						<i class="fa fa-eye"></i> View: [ 
						<span class='active' data-view="full">Full</span> |
						<span>Classic</span> ]
					</div>
				</div>
                <div class="panel-body">
                    <?php
                        foreach($cats as $cat){
							echo "<div class='cat'>";
								echo  '<div class="hidden-buttons">';
									echo '<a href="Categories.php?do=Edit&catid=' . $cat['Cat_ID'] .'" class="btn btn-xs btn-primary"><i class="fa fa-edit"></i> Edit</a>';
									echo '<a href="Categories.php?do=Delete&catid='. $cat['Cat_ID'] . '" class="confirm btn btn-xs btn-danger"><i class="fa fa-close"></i> Delete</a>';
								echo '</div>';
								echo '<h3>' .$cat['Name'] .'</h3>';
								echo '<div class="full-view">';
									echo '<p>' ;  if($cat['Description'] == ''){ echo 'The Category has no Description.'; }else {  echo $cat['Description'] ;}  echo '</p>' ;
									if ( $cat['Visibility'] == 1 ){ echo '<span class="visibilty"><i class="fa fa-eye"></i> Hidden</span>'; }
									if ( $cat['Allow_Comment'] == 1 ){ echo '<span class="allow-commenting"><i class="fa fa-close"></i> Comment Disable</span>'; }
									if ( $cat['Allow_Ads'] == 1 ){ echo '<span class="adverties"><i class="fa fa-close"></i> Ads Disable</span>'; }
								echo '</div>';
							// Get Child Categories
							$childCats =  getAllFrom("*" , "categories" , "WHERE Parent = {$cat['Cat_ID']}" , "" , "Cat_ID", "ASC");
							if(! empty($childCats)){
								echo "<h4 class='child-head'>Child Categories</h4>";
								echo "<ul class='list-unstyled child-cat'>";
									foreach($childCats as $childcat){
									  echo '<li class="child-link">
									  <a href=Categories.php?do=Edit&catid=' . $childcat['Cat_ID'] .'> '. $childcat['Name'] .' </a>
									  <a href="Categories.php?do=Delete&catid='. $childcat['Cat_ID'] . '" class="confirm show-delelte">Delete</a>
									  </li>';			
									}
								echo "</ul>";
							}
							echo "</div>";
							echo "<hr>";
                        }
                    ?>
                </div>
            </div>
			<a href='Categories.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> Add New Category</a>
        </div>
        
        
    <?php 
    }elseif($do == 'Edit'){
        // Edit Page
		
		
		// Check If get Request Method  Catid Is Numeric & get the Integer Value Of It 
	 	$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0 ; #Short  If condtion
		// Select All Data Depend On this ID
		 $stmt = $conect->prepare('SELECT * FROM Categories WHERE Cat_ID = ? ');
		//Execut Query 
		$stmt->execute(array($catid));
		// Fetch The Data 
		$cat = $stmt->fetch();
		// Row Count 
		$count = $stmt-> rowCount();
		// If There Is Such ID Show The Form 
		if ( $count > 0){ ?>
		
			<h1 class="text-center">Edit Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
					<input type="hidden" name="catid" value="<?php  echo $catid ;  ?> ">
					<!-- Start Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="username" name="name" class="form-control" required placeholder="Name Of The Category"
									   value="<?php  echo $cat['Name']; ?>" />
							</div>
						</div>
					<!-- End Name -->
					<!-- Start Description -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class=" form-control"   placeholder="Describe The Category"
									   value="<?php  echo $cat['Description']; ?>" />
								
							</div>
						</div>
					<!-- End Description -->
					<!-- Start Ordering  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="ordering" class="form-control"  placeholder="Number The Arrangment Of Category"
									   value="<?php  echo $cat['Ordering']; ?>" />
							</div>
						</div>
					<!-- End Ordering -->
					<!--  Start Parent -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent?</label>
							<div class="col-sm-10 col-md-6">
								<select name='parent' >
									<option value="0">None</option>
									<?php 
										$allcats = getAllFrom("*" , "categories" , "WHERE Parent = 0 " , "" ,"Cat_ID" , "ASC");
										foreach($allcats as $cats){
											echo"<option value='". $cats['Cat_ID'] ."'";
											if($cat['Parent'] == $cats['Cat_ID']){echo 'selected'; }
											echo ">".  $cats['Name']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--  Start Parent -->
					<!-- Start Visibilty  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="vis-yes" type="radio" name="visibility" value="0" <?php  if($cat['Visibility'] == 0 ) { echo 'checked' ;}  ?> />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibility" value="1"  <?php  if($cat['Visibility'] == 1 ) { echo 'checked' ;}  ?> />
                                    <label for="vis-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Visibilty -->
					<!-- Start Commenting  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commention</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0 ){echo'checked' ;}?>/>
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1 ){echo'checked' ;}?>/>
                                    <label for="com-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Commenting -->
                    <!-- Start Ads   -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" <?php  if($cat['Allow_Ads'] == 0 ) { echo 'checked' ;}?>/>
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" <?php  if($cat['Allow_Ads'] == 1 ) { echo 'checked' ;}?> />
                                    <label for="ads-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Ads -->
					<!-- Start Submit -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Category" class="btn btn-danger btn-lg">
							</div>
						</div>
					<!-- End Submit -->
					</form>	
				</div>
			
			<?php
		}else{
			$theMsg =  "<div class='alert alert-danger'>Theres No Such ID</div>";
			redirectPage($theMsg) ;
		}  // End Edit Page
		
    
    
    }elseif($do == 'Update'){
        // Update Page
		
			if($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo '<h1 class="text-center">Update Category</h1>' ;
			echo '<div class="container">';
			
			// Get The Variable Form The Form
			$id 		= $_POST['catid'];
			$name 		= $_POST['name'];
			$desc 		= $_POST['description'];
			$order 		= $_POST['ordering'];
			$parent		= $_POST['parent'];
			$visible 	= $_POST['visibility'];
			$comment 	= $_POST['commenting'];
			$ads 		= $_POST['ads'];
			// Update The In The Database 
			$stmt3 = $conect->prepare("UPDATE categories SET Name = ? , Description = ? , Ordering = ? , Parent = ? , Visibility = ? , Allow_Comment =?  , Allow_Ads = ? WHERE Cat_ID =?  ") ;
			$stmt3 ->execute(array($name , $desc , $order , $parent , $visible , $comment , $ads , $id ));
			
			//  Echo The Success Massage
			$theMsg =  '<div class="alert alert-success">' . $stmt3->rowCount() . ' Record Updated </div>' ;
			redirectPage( $theMsg , 'back');
			
			echo '</div>';
		}else {
			
			echo '<div class="container">';
				$theMsg = "<div class='alert alert-danger'>Sorry You can\'t Browse this Page Directy </div>";
				redirectPage($theMsg);
			echo '</div>';
		}
	
    
	
    }elseif($do == 'Add'){
        // Add Page  ?>
		<h1 class="text-center">Add A New Categories</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST">
					<!-- Start Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="username" name="name" class="form-control" autocomplete="off" required placeholder="Name Of The Category" />
							</div>
						</div>
					<!-- End Name -->
					<!-- Start Description -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Description</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="description" class="form-control"   placeholder="Describe The Category"/>
								
							</div>
						</div>
					<!-- End Description -->
					<!-- Start Ordering  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="ordering" class="form-control"  placeholder="Number The Arrangment Of Category" />
							</div>
						</div>
					<!-- End Ordering -->
					<!--  Start Parent -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent?</label>
							<div class="col-sm-10 col-md-6">
								<select name='parent' >
									<option value="0">None</option>
									<?php 
										$allcats = getAllFrom("*" , "categories" , "WHERE Parent = 0 " , "" ,"Cat_ID" , "ASC");
										foreach($allcats as $cats){
											echo"<option value='". $cats['Cat_ID'] ."'>".$cats['Name']."</option>";
										}
									?>
								</select>
							</div>
						</div>
					<!--  Start Parent -->
					<!-- Start Visibilty  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="vis-yes" type="radio" name="visibilty" value="0" checked />
                                    <label for="vis-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="vis-no" type="radio" name="visibilty" value="1" />
                                    <label for="vis-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Visibilty -->
					<!-- Start Commenting  -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Commention</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="com-yes" type="radio" name="commenting" value="0" checked />
                                    <label for="com-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="com-no" type="radio" name="commenting" value="1" />
                                    <label for="com-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Commenting -->
                    <!-- Start Ads   -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Allow Ads</label>
							<div class="col-sm-10 col-md-6">
								<div>
                                    <input id="ads-yes" type="radio" name="ads" value="0" checked />
                                    <label for="ads-yes">Yes</label>
                                </div>
                                <div>
                                    <input id="ads-no" type="radio" name="ads" value="1" />
                                    <label for="ads-no">No</label>
                                </div>
							</div>
						</div>
					<!-- End Ads -->
					<!-- Start Submit -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Category" class="btn btn-danger btn-lg">
							</div>
						</div>
					<!-- End Submit -->
					</form>	
				</div>
			
    <?php 
     
    }elseif($do == 'Insert'){
        //Insert Page
        
	 	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo "<h1 class='text-center'>Insert Category</h1>";
			echo "<div class='container'>";
			
	 		// Ger Variables from the form
			
	 		$name 	    = $_POST['name'];
	 		$desc 	    = $_POST['description'];
			$parent		= $_POST['parent'];
	 		$order 	    = $_POST['ordering'];
			$visible 	= $_POST['visibilty'];
	 		$comment 	= $_POST['commenting'];
            $ads     	= $_POST['ads'];
			
			
				//Check If Users Exist In Database
				
				$check = checkItem('Name' , 'categories' , $name );
				
				if($check == 1 ){
					$theMsg =  '<div class="alert alert-danger" >The Category Is Found In Database </div> ';
					redirectPage($theMsg , 'back') ;
				}else{
						
						// Insert Category  Info In Database
						$stmt = $conect->prepare( " INSERT INTO   categories( Name , Description , Parent , Ordering , Visibility , Allow_Comment , Allow_Ads )
													VALUES (  :inname , :inDesc , :inparent , :inorder , :invisibal , :incomment , :inads )");
						$stmt->execute(array( 
								'inname'	        => $name,
								'inDesc' 	        => $desc,
								'inparent'			=> $parent,
								'inorder' 	        => $order,
								'invisibal'         => $visible,
								'incomment'	        => $comment,
                                'inads'             => $ads
						));
						if($stmt){
							//echo Sucess Message
							$theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Inserted</div>';
							redirectPage($theMsg , 'back');  // Back Page to HTTP_REFERER After 3s
						}
					}
			
				echo "</div>";
	 	}else{
				echo '<div class="container">';
				$errorMsg = '<div class= "alert alert-danger">Sorry You cant Browse this Page Directy</div>';
				redirectHome($errorMsg );
				echo '</div>';
			} //End Insert Page
			
		
    }elseif($do == 'Delete'){
        // Delete Page
        	 	
		echo '<h1 class="text-center">Delete Category</h1>';
		echo '<div class="container">';
		
		$catid = isset($_GET['catid']) && is_numeric($_GET['catid'])? intval($_GET['catid']): 0 ;
		
		$check =  checkItem('Cat_ID' , 'categories' , $catid );
		
		if($check > 0){
			// Delete Member From Datatbase
			$stmt3 = $conect->prepare('DELETE FROM categories WHERE Cat_ID = :xid ');
			$stmt3->bindParam(':xid' , $catid);
			$stmt3->execute();
			//  Echo The Success Massage
			$theMsg =  '<div class="alert alert-success">' . $stmt3->rowCount() . ' Record Delete</div>';
			redirectPage($theMsg , 'back' );
			
		}else {
			$theMsg = '<div class="alert alert-danger">This ID is Not Exist </div>';
			redirectPage($theMsg );
		}
		
		echo '</div>';
    
		
    }elseif($do == 'Approived'){
        //Approvied Page
        
    }else{
        // 
    }

?>


<?php

    include  $tpl . 'footer.php';
}else{
        header('Location:index.php');
        exit();
    }
?>