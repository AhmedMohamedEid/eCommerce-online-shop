<?php
    ob_start();
    session_start();
    $pageTitle = 'Show Items';
    include 'init.php';
    
    // Check If get Request Method  Item_ID Is Numeric & get the Integer Value Of It 
    $itemid = isset($_GET['itemid']) && is_numeric($_GET['itemid'])? intval($_GET['itemid']): 0 ; #Short Code  If condtion
    // Select All Data Depend On this ID
     $stmt = $conect->prepare('SELECT
                                    items.* , categories.Name AS Category , users.Username AS Member
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
                               
                                WHERE
                                    Item_ID = ?
                                AND
                                    Approve = 1');
    //Execut Query 
    $stmt->execute(array($itemid));
    $count = $stmt->rowCount();
    if($count > 0 ){
        // Fetch The Data 
        $items = $stmt->fetch();    
        
?>
        <h1 class="text-center"><?php echo $items['Name'] ?></h1>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <img class="img-thumbnail center-block" src='uploaded\itemImg\<?php echo $items['Image'] ?>' alt='Item For Image' />
                </div>
                <div class="col-md-8 item-info">
                    <h2><?php echo $items['Name'] ?></h2>
                    <p><?php echo $items['Description'] ?></p>
                    <ul class="list-unstyled">
                        <li> <i class="fa fa-calendar fa-fw"></i>
                            <span>Add Date</span> :<?php echo $items['Add_Date'] ?>
                            </li>
                        <li> <i class="fa fa-money fa-fw"></i>
                            <span>Price</span> :$<?php echo $items['Price'] ?>
                            </li>
                        <li> <i class="fa fa-building fa-fw"></i>
                            <span>Made In</span> :<?php echo $items['Country_Made'] ?>
                            </li>
                        <li> <i class="fa fa-tags fa-fw"></i>
                            <span>Categorty</span> : <a href="categories.php?pageid=<?php echo $items['Cat_ID'] ?>"><?php echo $items['Category'] ?></a>
                            </li>
                        <li> <i class="fa fa-users fa-fw"></i>
                            <span>Added By</span> :<a href="#"><?php echo $items['Member'] ?></a>
                        </li>
                        <li class="tag"> <i class="fa fa-users fa-fw"></i>
                            <span>Tags</span> :
                            <?php
                                $alltags = explode("," , $items['Tags']);
                                foreach($alltags as $tag){
                                    $tag = str_replace(" " , "" ,$tag);
                                    $lowertag = strtolower($tag);
                                    if(! empty($tag)){
                                        echo "<a href='tags.php?name=". $lowertag . "'>".$tag . "</a>";
                                    }
                                }
                            ?>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Start Comment  -->
            <hr class='custom-hr'>
            <?php if(isset($_SESSION['Login'])){  ?>
                <div class="row">
                    <div class="col-md-offset-3">
                        <div class="add-comment">
                            <h3>Add Comment</h3>
                            <form action="<?php  echo $_SERVER['PHP_SELF'] . '?itemid='. $items['Item_ID'] ?>" method="POST">
                                <textarea class="form-control" name="comment" required></textarea>
                                <input class="btn btn-primary pull-right" type="submit" value="Add Comment" />
                            </form>
                            <?php
                                if($_SERVER['REQUEST_METHOD'] == 'POST' ){
                                    
                                    $comment = filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
                                    $itemid  = $items['Item_ID'] ;
                                    $userid  = $_SESSION['UserID'];
                                    
                                    if(! empty($comment)){
                                        $stmt = $conect -> prepare("INSERT INTO comments(Comment , Status , Comment_Date , Item_ID , User_ID)
                                                                   VALUES ( :zcomment , 0 , NOW() , :zitemid , :zuserid )");
                                        $stmt->execute(array(
                                                             'zcomment' => $comment ,
                                                             'zitemid'  => $itemid ,
                                                             'zuserid'  => $userid
                                                             ));
                                        if($stmt){
                                            echo"<div class='alert alert-success'>Comment Added</div>";
                                        }
                                    }else{
                                        echo"<div class='alert alert-danger'>Please Write your Comment </div>";
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            <?php }else{
                    echo"<p class='text-center'>You Must <a href='login.php'>Login or Register</a> to Add Comment</p>";
                }  ?>
            <hr class='custom-hr'>
            <?php 
                        // Select  All Users Except Admin
                       $stmt =$conect->prepare("SELECT
                                                   comments.* , users.Username AS Member , users.Image_Profile AS userImg
                                               FROM
                                                   comments
                                               INNER JOIN
                                                   users
                                               ON
                                                   users.User_ID = comments.User_ID
                                                WHERE
                                                    Item_ID =?
                                                AND
                                                    Status = 1
                                               ORDER BY C_ID DESC
                                               ");
                       
                       //Execute For Statement
                       $stmt ->execute(array($items['Item_ID']));
                       
                       // Assign  To Variables
                       $comments =$stmt ->fetchAll();
                        
                        foreach($comments as $comment){ ?>
                            <div class="comment-box">
                                <div class="row">
                                    <div class="col-sm-2 text-center">
                                        <?php
                                            if(empty($comment['userImg'])){
                                                echo"<img class='img-responsive img-thumbnail img-circle' src='uploaded\imageProfile\imgProfile.png' alt='Member' />";
                                            }else{
                                                echo"<img class='img-responsive img-thumbnail img-circle' src='uploaded\imageProfile\\". $comment['userImg']  . "' alt='Member' />";
                                            }
                                        ?>
                                        <h4><?php echo ucfirst($comment['Member']) ?></h4>
                                    </div>
                                    <div class="col-sm-10">
                                        <div class="commnent">
                                            <p class="lead"><?php  echo $comment['Comment'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <?php } ?>
                
            </div>
            <!-- Start Comment  -->
        </div>


<?php
    }else{
        echo'<div class="container">';
            echo'<div class="alert alert-danger text-center">There No Such ID Or This item is Waiting Approval </div>';
        echo '</div>';
    }
    include  $tpl . 'footer.php';
    ob_end_flush();
?>