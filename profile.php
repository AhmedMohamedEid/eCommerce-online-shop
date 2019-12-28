<?php
    ob_start();
    session_start();
    $pageTitle = 'My Profile';
    include 'init.php';
    if(isset($_SESSION['Login'])){
        $getUserInfo = $conect->prepare("SELECT * FROM users WHERE Username = ?");
        $getUserInfo->execute(array($sessionUser));
        $info = $getUserInfo ->fetch();
        $usersInfoId = $info['User_ID'];
       /*
        // Get Variabel 
        $imgName    = $_FILES['member-img']['name'];
        $imgTmp     = $_FILES['member-img']['tmp_name'];
        $imgSize    = $_FILES['member-img']['size'];
        $imgType    = $_FILES['member-img']['Type'];
        
        $imgAlloweExtension = array("png" , "jpeg" , "jpg" , "gif");
        
        $imgExtension = explode("." , $imgName);
        $extension = strtolower(end($imgExtension));
        
        $image = rand(0 ,1000000) . '_' . $imgName ;
		move_uploaded_file($imgTmp , "uploaded\imageProfile\\".$image  );
        // Insert User Info In Database
				$stmt = $conect->prepare( " UPDATE items SET Image_Profile = ? ");
				$stmt->execute(array($image));
		
		*/
        
?>
        <h1 class="text-center"><?php echo $_SESSION['Login'] ?> Profile</h1>
        <div class="information block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My Information</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-9">
                                <ul class="list-unstyled">
                                    <li> <i class="fa fa-unlock-alt fa-fw"></i>
                                        <span>Name</span> : <?php echo $info['Username']; ?>
                                    </li>
                                    <li> <i class="fa fa-envelope-o fa-fw"></i>
                                        <span>Email</span> : <?php echo $info['Email']; ?>
                                    </li>
                                    <li> <i class="fa fa-user fa-fw"></i>
                                        <span>Full Name</span> : <?php echo $info['FullName']; ?>
                                    </li>
                                    <li> <i class="fa fa-calendar fa-fw"></i>
                                        <span>Regisiter Date</span> : <?php echo $info['Date']; ?>
                                    </li>
                                    <li> <i class="fa fa-tags fa-fw"></i>
                                        <span>Favourite Cat</span> : <?php echo $info['Username']; ?>
                                    </li>
                                </ul>
                                <a href="#" class="btn edit btn-default" >Edit</a>
                            </div>
                            <div class="col-md-3">
                                <div class="profile-img pull-right">
                                    <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
                                        <?php
                                            if(empty($info['Image_Profile'])){
                                                echo'<img class="img-responsive img-thumbnail" src="uploaded\imageProfile\imgProfile.png" alt="Profile Image"/>';
                                            }else{
                                                echo '<img class="img-responsive img-thumbnail" src="uploaded\imageProfile\\'.$info['Image_Profile'].'" alt="Profile Image"/>';
                                            }
                                        ?>
                                        <input type="file" name="member-img" />
                                        <input type="submit" name="upload" class="btn btn-default btn-xs" value="Change Image"/>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="my_Ads" class="my-ads block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">My Ads</div>
                    <div class="panel-body">
                            <?php
                            $getItem =  getAllFrom("*" , "items" , "WHERE Member_ID = $usersInfoId" , "" , "Item_ID" );
                            if(! empty($getItem)){
                                echo '<div class="row">';
                                    foreach($getItem as $item){
                                        echo "<div class='col-md-3 col-sm-6'>";
                                            echo "<div class='thumbnail item-box'>";
                                                if($item['Approve'] == 0 ){
                                                    echo "<span class='approve-status' > Waiting Approval </span>";
                                                }
                                                echo"<span class='price-tag'>$". $item['Price'] . "</span>";
                                                if(empty($item['Image'])){
                                                    echo"<img src='layout/images/image.png' alt='Item For Image' />";
                                                }else{
                                                    echo"<img src='uploaded\itemImg\\". $item['Image'] ."' alt='Item For Image' />";
                                                }
                                                echo "<div class='caption'>";
                                                    echo "<h3><a href='item.php?itemid=".$item['Item_ID']."'>". ucfirst($item['Name']) ."</a></h3>";
                                                    echo "<p>". ucfirst($item['Description']) ."</p>";
                                                    echo "<div class='date'>". $item['Add_Date'] ."</div>";
                                                echo "</div>";
                                            echo "</div>";
                                        echo "</div>";
                                    }
                                echo '</div>';
                            }else{
                                echo "<div class='alert alert-danger text-center'>There's No Ads , <a href='newads.php'>Add New Ads</a></div>";  
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="my-comment block">
            <div class="container">
                <div class="panel panel-primary">
                    <div class="panel-heading">Latest Comments</div>
                    <div class="panel-body">
                        <?php
                            $stmtz = $conect ->prepare("SELECT Comment FROM comments WHERE User_ID = ?");
                            $stmtz ->execute(array($info['User_ID'])) ;
                            $comments = $stmtz ->fetchAll();
                            
                            if(!empty($comments)){
                                foreach($comments as $comment){
                                    echo'<h2>'. $comment['Comment'] . '</h2>';
                                }
                            }else{
                                echo "<div class='alert alert-danger text-center'>There's No Comments</div>";
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

<?php
    }else{
        header('location: Login.php');
        exit();
    }
    include  $tpl . 'footer.php';
    ob_end_flush();
?>