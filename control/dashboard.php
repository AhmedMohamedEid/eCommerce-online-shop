<?php
ob_start(); // Output Buffring Start
session_start();
if(isset ($_SESSION['Admin_login'])){
    $pageTitle = 'Dashboard';
    include 'init.php';
    
 /* Start Dashboard */
        
        // Function for Get Last User Records
         $numUser = 4 ; // Number for Last User Records 
        $latestUser = getLatest( "*" , "users" , "User_ID" , $numUser );  // Function for Get Last User Records
        $numItem = 4;  // Number for Last Items Records 
        $latestItem = getLatest("*" , "items", "Item_ID" , $numItem);
        $numComments = 4  // Number for Last Comment Records
?>
        <div class="container home-stat text-center">
            <h1>Dashboard</h1>
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <div class="stats st-member">
                        <i class="fa fa-users"></i>
                        <div class="info">
                            Total Members
                           <a href="members.php"> <span><?php echo countItems( 'User_ID' , 'users', 'Group_ID') ; ?> </span>  </a>
                        </div>
                   </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats st-pending">
                        <i class="fa fa-user-plus"></i> 
                        <div class="info">
                            Pending Members
                            <a href="members.php?do=Manage&page=Pending"><span>
                                <?php  echo checkItem( 'Regstatus' , 'users' , 0) ?>
                            </span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats st-items">
                        <i class="fa fa-tag"></i>
                        <div class="info">
                            Total Items
                            <a href="items.php"> <span><?php echo countItems( 'Item_ID' , 'items') ; ?> </span>  </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="stats st-comment">
                        <i class="fa fa-comments"></i>
                        <div class="info">
                           Total Commnet
                            <a href="comments.php"> <span><?php echo countItems( 'C_ID' , 'comments') ; ?> </span>  </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Last News  -->
        <div class="container letest">
            <div class="row">
                <div class="col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-users"></i> Letest <?php echo $numUser ?> Register Users
                            <span class="toggel-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                if(! empty($latestUser)){
                                    foreach( $latestUser as $user ){
                                        echo '<li>' . ucfirst($user['Username']) .'
                                                <a href="members.php?do=Edit&userid='. $user['User_ID'] .' ">
                                                    <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit</span>
                                                </a>';
                                            if($user['Regstatus'] == 0){
                                                
                                                echo "<a href = 'members.php?do=Activate&userid=". $user['User_ID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Activated</a>";
                                            }
                                        echo '</li>' ;
                                    }
                                }else{
                                    echo"<div class='alert alert-danger'>Not Found Members</div>";
                                }
                                    
                                
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-tag"></i> Letest <?= $numItem ?> Items
                             <span class="toggel-info pull-right">
                                <i class="fa fa-plus fa-lg"></i>
                            </span>
                        </div>
                        <div class="panel-body">
                            <ul class="list-unstyled latest-users">
                                <?php
                                    if(! empty($latestItem)){
                                        foreach($latestItem as $item){
                                                echo "<li>" . ucfirst($item['Name']) .'<a href= "items.php?do=Edit&itemid='. $item['Item_ID'] . '"> <span class="btn btn-success pull-right"><i class="fa fa-edit"></i> Edit</span></a>';
                                                    if($item['Approve']== 0){
                                                        echo "<a href = 'items.php?do=Approve&itemid=". $item['Item_ID'] . "' class='btn btn-info pull-right activate'><i class='fa fa-check'></i> Approve</a>"; 
                                                    }
                                                echo '</li>';
                                            }
                                    }else{
                                        echo"<div class='alert alert-danger'>Not Found Items</div>";  
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!--  Start Comments -->
                
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <i class="fa fa-comments-o"></i> Letest <?= $numComments ?> Comments
                                <span class="toggel-info pull-right">
                                    <i class="fa fa-plus fa-lg"></i>
                                </span>
                            </div>
                            <div class="panel-body">
                                <ul class="list-unstyled latest-users">
                                    <?php
                                     
                                        $stmt =$conect->prepare("SELECT
                                                                    comments.* , users.Username AS Member
                                                                FROM
                                                                    comments
                                                                INNER JOIN
                                                                    users
                                                                ON
                                                                    users.User_ID = comments.User_ID
                                                                ORDER BY C_ID DESC
                                                                LIMIT $numComments
                                                                ");
                                        //Execute For Statement
                                        $stmt ->execute();
                                        $coms =$stmt ->fetchAll();
                                        if(! empty($coms)){
                                            foreach( $coms as $com){
                                                ?>
                                                <div class='comment-box'>
                                                    <div class='row'>
                                                        <div class='col-xs-3'>
                                                                <span class='comment-member'>
                                                                    <a href='members.php?do=Edit&userid=<?= $com['User_ID'];?>'><?= ucfirst($com['Member']) ?> </a>
                                                                </span>
                                                            </div>
                                                        <div class='col-xs-9'>
                                                            <div class="comment-text">
                                                                <p><?= $com['Comment'] ?></p>
                                                                
                                                                <!-- Single button -->
                                                                <div class="btn-group btn-d-e">
                                                                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                     <span class="caret"></span>
                                                                  </button>
                                                                  <ul class="dropdown-menu">
                                                                    <li><a href="comments.php?do=Edit&comid=<?= $com['C_ID'] ?>">Edit</a></li>
                                                                    <li><a href="comments.php?do=Delete&comid=<?= $com['C_ID'] ?>" class="confirm">Delete</a></li>
                                                                  </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr/>
                                                </div>
                                                
                                 <?php      }
                                        }else{
                                          echo"<div class='alert alert-danger'>Not Found Comments</div>";  
   
                                        }
                                    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
            
            <!--  End Comments --> 

        </div>

<?php

    include  $tpl . 'footer.php';
}else{
        header('Location:index.php');
        exit();
    }
ob_end_flush();
?>