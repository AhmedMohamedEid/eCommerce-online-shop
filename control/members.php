<?php

/*
 *================================
 *== Mange Members Page
 *== You Can Add | Delete | Edit 
 *================================
 */
ob_start();

session_start();

$pageTitle = 'Members';

if(isset ($_SESSION['Admin_login'])){
    
    include 'init.php';    
    $do = isset($_GET['do'])?$_GET['do'] : 'Manage';
    
    
	
	
    if($do == 'Manage'){
    // Manage Page
	
		$query ='';
		if(isset($_GET['page']) && $_GET['page'] == 'Pending'){
			
			$query = 'AND Regstatus = 0';
		}
	
        // Select  All Users Except Admin
			$stmt =$conect->prepare("SELECT * FROM users WHERE Group_ID !=1 $query ORDER BY User_ID DESC");
			
			//Execute For Statement
			$stmt ->execute();
			
			// Assign  To Variables
			$rows =$stmt ->fetchAll();
			if(! empty($rows)){
			?>
			<h1 class="text-center">Manage Member</h1>
		 	<div class="container">
				<div class="table-responsive">
					<table class="main-table manage-member text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Image</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Phone</td>
							<td>Registerd Date</td>
							<td>Control</td>
						</tr>
						<?php 
						foreach($rows  as $row ){  // loop Veiw Member From Database
							echo '<tr>';
								echo'<td>'. $row['User_ID'] . '</td>';
								echo'<td>';
								if(empty($row['Image_Profile'])){
									echo '<img src="..\uploaded\imageProfile\imgProfile.png" alter= "Image" />';
								}else{
									echo'<img src="..\uploaded\imageProfile\\' . $row['Image_Profile'] . '"alter= "Image" />';
								}
								echo'</td>';
								echo'<td>' . ucfirst($row['Username']) . '</td>';
								echo'<td>' . strtolower($row['Email']) . '</td>';
								echo'<td>' . ucfirst($row['FullName']) . '</td>';
								echo'<td>' . $row['Phone'] . '</td>';
								echo'<td>' . $row['Date'] .'</td>';
								echo"<td>
										<a href = 'members.php?do=Edit&userid=". $row['User_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i> Edit</a>
										<a href = 'members.php?do=Delete&userid=". $row['User_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i> Delete</a>";
									if($row['Regstatus'] == 0){
										echo "<a href = 'members.php?do=Activate&userid=". $row['User_ID'] . "' class='btn btn-info activate'><i class='fa fa-check'></i> Activated</a>";

									}
								echo"</td>"; 
							echo '</tr>';
						}
						
						?>
						
					</table>
				</div>
				<a href="members.php?do=Add" class="btn btn-primary"> <i class="fa fa-plus"></i> New Membar</a>
				
			</div>
			<?php
			}else{
				echo "<div class='container'>";
					echo "<div class='alert alert-info'>Welcom Mr.<strong>". $_SESSION['login'] ."</strong> Not Found Member & if do you wont to <strong>Add New Member</strong> is <a href='members.php?do=Add' >Here</a>
					</div>";
				echo"</div>";
				
			}
    }elseif($do == 'Edit'){  // Edit Page
        
        // Check If get Request Method  User_ID Is Numeric & get the Integer Value Of It 
	 	$userid = isset($_GET['userid']) && is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ; #Short Code  If condtion
		// Select All Data Depend On this ID
		 $stmt = $conect->prepare('SELECT * FROM users WHERE User_ID = ?  LIMIT 1');
		//Execut Query 
		$stmt->execute(array($userid));
		// Fetch The Data 
		$row = $stmt->fetch();
		// Row Count 
		$count = $stmt-> rowCount();
		// If There Is Such ID Show The Form 
		if ( $count > 0){ ?>
            <h1 class="text-center">Edit Member</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="userid" value="<?php echo $userid ?>">
                    <!-- Start Username -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Username</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="username" class="form-control" value="<?php echo $row['Username']; ?>" autocomplete="off" required/>
                            </div>
                        </div>
                    <!-- End Username -->
                    <!-- Start Password -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="hidden" name="oldpassword" value="<?php echo $row['Password']; ?>" />
                                <input type="password" name="newpassword" class="form-control" autocomplete="new-password"/>
                            </div>
                        </div>
                    <!-- End Password -->
                    <!-- Start Email -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Email</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="email" name="email" class="form-control" value="<?php echo $row['Email']; ?>" required />
                            </div>
                        </div>
                    <!-- End Email -->
                    <!-- Start Birthday -->
                    <div class="form-group form-group-lg">
                        <label class="col-sm-2 control-label">Birthday</label>
                        <div class="col-sm-10 col-md-6">
                            <input type='date' name="birthday" value="<?php echo $row['Date']; ?>" />
                        </div>
                    </div>
                    <!-- End Birthday -->
                    <!-- Start Phone -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Phone</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="phone" class="form-control" value="<?php echo $row['Phone']; ?>" />
                            </div>
                        </div>
                    <!-- End Phone -->
                    <!-- Start Full Name -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="text" name="full" class="form-control" value="<?php echo $row['FullName']; ?>" required />
                            </div>
                        </div>
                    <!-- End Full Name -->
					<!-- Start image Profile  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Full Name</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="file" name="image_profile" class="form-control"  required  value= "<?php echo $row['Image_Profile']; ?>"/>
                            </div>
                        </div>
                    <!-- End image Profile -->
                    <!-- Start Gender --> <?php /*
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Gender</label>
                            <div class="col-sm-10 col-md-6">
                                <input id="gen-male" type="radio" name="gender"   value="0" <?php if($row['Gender'] == 0 ) { echo 'checked'; } ?> />
                                <label for="gen-male">Male</label>
                                <input id="gen-female" type="radio" name="gender" value="1" <?php if($row['Gender'] == 1 ) { echo 'checked'; } ?> />
                                <label for="gen-female">Female</label>
                            </div>
                        </div>
                    <!-- End Gender --> */?>
                    <!-- Start Submit -->
                        <div class="form-group form-group-lg">
                            <div class="col-sm-offset-2 col-sm-10">
                                <input type="submit" value="Save" class="btn btn-danger btn-lg">
                            </div>
                        </div>
                    <!-- End Submit -->
                    
                </form>	
            </div>		 	        
            
        
    <?php
        }else{
            echo'There is Not Such ID';
        }
    }elseif($do == 'Update'){
        // Update Page
        
		   if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			   echo "<h1 class='text-center'>Update Member</h1>";
			   echo "<div class='container'>";
			   
			   // Upload Variables
				#	$imgProfile  = $_FILES['image_profile'];
			
				$imgName 	= $_FILES['image_profile']['name'];
				$imgSize 	= $_FILES['image_profile']['size'];
				$imgTmp 	= $_FILES['image_profile']['tmp_name'];
				$imgtype 	= $_FILES['image_profile']['type'];
				
				// List Of Allowed  File Typed to Upload
				$imageAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
				
				// Get Image Extension
				$imageExtension =explode(".", $imgName);
				$extension = strtolower(end($imageExtension));
			   
			   
			   // Get Variables from the form
			   $id 		= $_POST['userid'];
			   $user 	= $_POST['username'];
			   $email 	= $_POST['email'];
			   $name 	= $_POST['full'];
			   $phone   = $_POST['phone'];
			   $birthday= $_POST['birthday'];
   
			   // password trick 
   
			   $pass = empty($_POST['newpassword'])? $_POST['oldpassword'] : sha1($_POST['newpassword']);
			   
			   // Validate Form 
			   $formErrors = array();
			   if (strlen($user) < 4) {
				   $formErrors[] ='Username Cant Be less Than <strong>3 characters</strong>';
			   }
			   if (strlen($user) > 20){
				   $formErrors[] = 'Username Cant Be More Than <strong>20 characters</strong>';
			   }
			   if (empty($user)) {
				   $formErrors[] ='Username Cant Be <strong>empty</strong>'; 
			   }
			   if (empty($email)) {
				   $formErrors[] ='Email Cant Be <strong>empty</strong>'; 
			   }
			   if (strlen($phone) < 11) {
				   $formErrors[] ='Phone Number Less Than <strong>11</strong> Number'; 
			   }
			   if (empty($name)) {
				   $formErrors[] ='Name Cant Be <strong>empty</strong>'; 
			   }
			   
			   if(!empty($imgName) && ! in_array($extension , $imageAllowedExtension)){
					$formErrors[] ='The Extension is Not <strong>Allowed</strong>'; 
				}
				
				if(empty($imgName)){
					$formErrors[] ='The Image is <strong>Reqiurd</strong>'; 
				}
				
				if($imgSize > 4109304){
					$formErrors[] ='The Image Size is larger than <strong>4MB</strong>'; 
				}
				
				// Loop Into Errors Array And Echo It 
			   foreach ($formErrors as $error) {
				  echo   '<div class="alert alert-danger">' . $error . '</div>' ;
				   
			   }
				// Check if There is no database proceed the Update Operation ----***** 
			   if (empty($formErrors)){
				
					$image = rand(0 ,1000000) . '_' . $imgName ;
					move_uploaded_file($imgTmp , "..\uploaded\imageProfile\\".$image  );
					
					$stmt2 = $conect ->prepare('SELECT * FROM users WHERE Username = ? AND User_ID != ?');
					$stmt2 ->execute(array($user , $id));
					$count = $stmt2 ->rowCount();
					if($count == 1){
						$msg = "<div class='alert alert-danger'>Sorry This User Is Exist</div>";
						redirectPage( $msg , 'back');
					}else{
						// Update The Data Name With Info
					   $stmt = $conect -> prepare('UPDATE users SET Username =? , Email =? , FullName =? , Password =? , Phone =? ,Date = ? ,  Image_Profile = ? WHERE User_ID=?  ORDER BY User_ID DESC');
					   $stmt->execute(array($user ,$email , $name ,$pass , $phone , $birthday, $image ,$id  ));
					   //echo Success Message
					   
					  $theMsg = '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Updated</div>';
						redirectPage($theMsg, 'back');
					}
				   
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
    }elseif($do == 'Add'){
        // Add Page ?>
        <h1 class="text-center">Add A New Member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Username -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control" autocomplete="off"  required placeholder="Username To Login Web Server" />
							</div>
						</div>
					<!-- End Username -->
					<!-- Start Password -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-6">
								<input type="password" name="password" class="password form-control" autocomplete="new-password" required placeholder="Password Must Be Hard & Complex"/>
								<i class="show-pass fa fa-eye-slash fa-1x"></i>
							</div>
						</div>
					<!-- End Password -->
					<!-- Start Email -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" class="form-control" required placeholder="Email Must Be Valid" />
							</div>
						</div>
					<!-- End Email -->
					<!-- Start Phone Number -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Phone</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="phone" class="form-control"  placeholder="Phone Number" />
							</div>
						</div>
					<!-- End Phone Number -->
					<!-- Start Full Name -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full" class="form-control" required placeholder="Full Name Appear In Your Profile Page" />
							</div>
						</div>
					<!-- End Full Name -->
					<!-- Start Gender -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Gender</label>
							<div class="col-sm-10 col-md-6">
								<input type="radio" name="gender"  value="1" required checked /> Male 
								<input type="radio" name="gender"  value="2" required /> female
								<input type="radio" name="gender"  value="3" required  /> Other 
							</div>
						</div>
					<!-- End Gender -->
					<!-- Start image Profile  -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">User Image</label>
                            <div class="col-sm-10 col-md-6">
                                <input type="file" name="image_profile" class="form-control"  required />
                            </div>
                        </div>
                    <!-- End image Profile -->
					<!-- Start Submit -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Member" class="btn btn-danger btn-lg">
							</div>
						</div>
					<!-- End Submit -->
					</form>	
				</div>
	<?php 
    }elseif($do == 'Insert'){
        //Insert Page
        
	 	if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			echo "<h1 class='text-center'>Insert Member</h1>";
			echo "<div class='container'>";
			// Upload Variables
				#	$imgProfile  = $_FILES['image_profile'];
			
				$imgName 	= $_FILES['image_profile']['name'];
				$imgSize 	= $_FILES['image_profile']['size'];
				$imgTmp 	= $_FILES['image_profile']['tmp_name'];
				$imgtype 	= $_FILES['image_profile']['type'];
				
				// List Of Allowed  File Typed to Upload
				$imageAllowedExtension = array("jpeg" , "jpg" , "png" , "gif");
				
				// Get Image Extension
				$imageExtension =explode(".", $imgName);
				$extension = strtolower(end($imageExtension));
				
	 		// Ger Variables from the form
			
	 		$user 	= $_POST['username'];
	 		$pass 	= $_POST['password'];
	 		$email 	= $_POST['email'];
			$phone 	= $_POST['phone'];
	 		$name 	= $_POST['full'];
			
			$hashPass = sha1($_POST['password']);
	 		
			
			// Validate Form 
	 		$formErrors = array();
			
	 		if (strlen($user) < 4) {
	 			$formErrors[] ='Username Cant Be less Than <strong>3 characters</strong>';
	 		}
			if (strlen($user) > 20){
				$formErrors[] = 'Username Cant Be More Than <strong>20 characters</strong>';
			}
			if (empty($user)) {
	 			$formErrors[] ='Username Cant Be <strong>empty</strong>'; 
	 		}
			if (empty($pass)) {
	 			$formErrors[] ='Password Cant Be <strong>empty</strong>'; 
	 		}
	 		if (empty($email)) {
	 			$formErrors[] ='Email Cant Be <strong>empty</strong>'; 
	 		}
			if (strlen($phone) < 11) {
				   $formErrors[] ='Phone Number Less Than <strong>11</strong> Number'; 
			}
			
	 		if (empty($name)) {
	 			$formErrors[] ='Name Cant Be <strong>empty</strong>'; 
	 		}
			
			if(!empty($imgName) && ! in_array($extension , $imageAllowedExtension)){
				$formErrors[] ='The Extension is Not <strong>Allowed</strong>'; 
			}
			
			if(empty($imgName)){
				$formErrors[] ='The Image is <strong>Reqiurd</strong>'; 
			}
			
			if($imgSize > 4109304){
				$formErrors[] ='The Image Size is larger than <strong>4MB</strong>'; 
			}
			// Loop Into Errors Array And Echo It 
	 		foreach ($formErrors as $error) {
	 			echo '<div class="alert alert-danger">' . $error . '</div>' ;
	 		}
			// Check if There is no database proceed the Insert Operation ----*****
			
			if (empty($formErrors)){
				$image = rand(0 ,1000000) . '_' . $imgName ;
				move_uploaded_file($imgTmp , "..\uploaded\imageProfile\\".$image  );
				
			
				//Check If Users Exist In Database	
				$check = checkItem('Username' , 'users' , $user );
				
				if($check == 1 ){
					$theMsg =  '<div class="alert alert-danger" The Name Is Found In Database </div> ';
					redirectPage($theMsg , 'back') ;
				}else{
						// Insert User Info In Database
						$stmt = $conect->prepare( " INSERT INTO   users( Username, Password, Email, Phone , FullName , Regstatus, Date , Image_Profile )
													VALUES (  :user ,:pass  , :mail , :phone , :name , 1 , now() , :imgProfile)");
						$stmt->execute(array( 
								'user'		 => $user,
								'pass' 		 => $hashPass,
								'mail' 		 => $email,
								'phone' 	 => $phone,
								'name'		 => $name,
								'imgProfile' => $image
						));
						
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
        	 	
		echo "<h1 class='text-center'>Delete Member</h1>";
		echo "<div class='container'>";
		
			// Check If get Request Method  UserID Is Numeric & get the Integer Value Of It 
			$userid = isset($_GET['userid'])&& is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ; #Short  If condtion
			// Select All Data Depend On this ID
						//$stmt = $conect->prepare('SELECT * FROM users WHERE UserID = ?  LIMIT 1');
			$check = checkItem( 'User_ID' , 'users' , $userid);   // Function From Function File Name CheckItem 
							/*//Execut Query 
							   //$stmt->execute(array($userid));
							   // Row Count 
								*/		//$count = $stmt-> rowCount();
			// If There Is Such ID Show The Form 
			if ( $check > 0){
				// Delete Member From Datatbase
				$stmt = $conect->prepare("DELETE FROM users WHERE User_ID = :xuser");
				$stmt->bindParam(':xuser', $userid);
				$stmt->execute();
				// Echo Success Message
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Delete</div>';
				redirectPage($theMsg , 'back' );
					
			}else{
				$theMsg = '<div class="alert alert-success">This ID is Not Exist</div>';
				redirectPage($theMsg );
			}
		echo "</div>";
    }elseif($do == 'Activate'){
        //Approvied Page
		
		echo "<h1 class='text-center'>Approived Member</h1>";
		echo "<div class='container'>";
		
			// Check If get Request Method  UserID Is Numeric & get the Integer Value Of It 
			$userid = isset($_GET['userid'])&& is_numeric($_GET['userid'])? intval($_GET['userid']): 0 ; #Short  If condtion
			// Select All Data Depend On this ID
						//$stmt = $conect->prepare('SELECT * FROM users WHERE UserID = ?  LIMIT 1');
			$check = checkItem( 'User_ID' , 'users' , $userid);   // Function From Function File Name CheckItem 
							/*//Execut Query 
							   //$stmt->execute(array($userid));
							   // Row Count 
								*/		//$count = $stmt-> rowCount();
			// If There Is Such ID Show The Form 
			if ( $check > 0){
				// Delete Member From Datatbase
				$stmt = $conect->prepare("UPDATE users SET Regstatus = 1 WHERE User_ID = ? ");
				$stmt->execute(array($userid));
				// Echo Success Message
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Activate</div>';
				redirectPage($theMsg , 'back' );
					
			}else{
				$theMsg = '<div class="alert alert-success">This ID is Not Exist</div>';
				redirectPage($theMsg );
			}
		echo "</div>";
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