<?php

/*
 *================================
 *== Mange Comments Page
 *== You Can  Delete | Edit  | Approve  Comments
 *================================
 */
ob_start();

session_start();

$pageTitle = 'Comment';

if(isset ($_SESSION['Admin_login'])){
    
    include 'init.php';    
    $do = isset($_GET['do'])?$_GET['do'] : 'Manage';
	
    if($do == 'Manage'){
    // Manage Page
        // Select  All Users Except Admin
			$stmt =$conect->prepare("SELECT
                                        comments.* , items.Name AS Item_Comment, users.Username AS User_comment
                                    FROM
                                        comments
                                    INNER JOIN
                                        items
                                    ON
                                        items.Item_ID = comments.Item_ID
                                    INNER JOIN
                                        users
                                    ON
                                        users.User_ID = comments.User_ID
									ORDER BY C_ID DESC
                                    ");
			
			//Execute For Statement
			$stmt ->execute();
			
			// Assign  To Variables
			$coms =$stmt ->fetchAll();
			?>
			<h1 class="text-center">Manage Comment</h1>
		 	<div class="container">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Commet</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>
						<?php 
						foreach($coms  as $com ){  // loop Veiw Member From Database
							echo '<tr>';
								echo'<td>' . $com['C_ID'] . '</td>';
								echo'<td>' . $com['Comment'] . '</td>';
								echo'<td>' . $com['Item_Comment'] . '</td>';
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
			</div>
        <?php 
    }elseif($do == 'Edit'){  // Edit Page
        
        // Check If get Request Method  User_ID Is Numeric & get the Integer Value Of It 
	 	$comid = isset($_GET['comid']) && is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ; #Short Code  If condtion
		// Select All Data Depend On this ID
		 $stmt = $conect->prepare('SELECT * FROM comments WHERE C_ID = ? ');
		//Execut Query 
		$stmt->execute(array($comid));
		// Fetch The Data 
		$row = $stmt->fetch();
		// Row Count 
		$count = $stmt-> rowCount();
		// If There Is Such ID Show The Form 
		if ( $count > 0){ ?>
            <h1 class="text-center">Edit Comment</h1>
            <div class="container">
                <form class="form-horizontal" action="?do=Update" method="POST">
                    <input type="hidden" name="comid" value="<?php echo $comid ?>">
                    <!-- Start Comment -->
                        <div class="form-group form-group-lg">
                            <label class="col-sm-2 control-label">Comment</label>
                            <div class="col-sm-10 col-md-6">
                                <textarea class="form-control" name="comment"><?php echo $row["Comment"]  ?></textarea>
                            </div>
                        </div>
                    <!-- End Comment -->
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
            echo'There is Not Such ID For This is Comment';
        }
    }elseif($do == 'Update'){
        // Update Page
        
		   if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			   echo "<h1 class='text-center'>Update Comment</h1>";
			   echo "<div class='container'>";
			   
			   // Get Variables from the form
			   $comid 		= $_POST['comid'];
			   $comm 	    = $_POST['comment'];

			   // Validate Form 
			   $formErrors = array();
               
			   if (empty($comm)) {
				   $formErrors[] ='Comment Cant Be <strong>empty</strong>'; 
			   }
			   
				// Loop Into Errors Array And Echo It 
			   foreach ($formErrors as $error) {
				  echo   '<div class="alert alert-danger">' . $error . '</div>' ;
				   
			   }
				// Check if There is no database proceed the Update Operation ----***** 
			   if (empty($formErrors)){
				
					// Update The Data Name With Info
				   $stmt = $conect -> prepare('UPDATE comments SET Comment =?  WHERE C_ID=? ');
				   $stmt->execute(array($comm , $comid  ));
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
        	 	
		echo "<h1 class='text-center'>Delete Comment</h1>";
		echo "<div class='container'>";
		
			// Check If get Request Method  UserID Is Numeric & get the Integer Value Of It 
			$comid = isset($_GET['comid'])&& is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ; #Short  If condtion
			// Select All Data Depend On this ID
			$check = checkItem( 'C_ID' , 'comments' , $comid);   // Function From Function File Name CheckItem 
			// If There Is Such ID Show The Form 
			if ( $check > 0){
				// Delete Member From Datatbase
				$stmt = $conect->prepare("DELETE FROM comments WHERE C_ID = :xuser");
				$stmt->bindParam(':xuser', $comid);
				$stmt->execute();
				// Echo Success Message
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Delete</div>';
				redirectPage($theMsg , 'back' );
					
			}else{
				$theMsg = '<div class="alert alert-success">This ID is Not Exist</div>';
				redirectPage($theMsg );
			}
		echo "</div>";
    }elseif($do == 'Approve'){
        //Approvied Page
		
		echo "<h1 class='text-center'>Approived Comment</h1>";
		echo "<div class='container'>";
		
			// Check If get Request Method  UserID Is Numeric & get the Integer Value Of It 
			$comid = isset($_GET['comid'])&& is_numeric($_GET['comid'])? intval($_GET['comid']): 0 ; #Short  If condtion
			// Select All Data Depend On this ID
			$check = checkItem( 'C_ID' , 'comments' , $comid);   // Function From Function File Name CheckItem 
							
			// If There Is Such ID Show The Form 
			if ( $check > 0){
				// Delete Member From Datatbase
				$stmt = $conect->prepare("UPDATE comments SET Status = 1 WHERE C_ID = ? ");
				$stmt->execute(array($comid));
				// Echo Success Message
				$theMsg =  '<div class="alert alert-success">' . $stmt->rowCount() . ' Recorde Approve</div>';
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