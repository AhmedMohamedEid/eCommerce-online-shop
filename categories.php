<?php
    session_start();
    $pageTitle = 'Categories';
    
    include 'init.php';
    ?>
    
    
<div class="container">
    <h1 class="text-center">Show Category</h1>
    <div class="row">
        <?php
            if(isset($_GET['pageid']) && is_numeric($_GET['pageid'])){
                $allItems = getAllFrom("*" , "items" , "where Cat_ID = {$_GET['pageid']}" , "AND Approve = 1" ,"Item_ID" );
                #  $items = getItem('Cat_ID',$_GET['pageid']);
                foreach($allItems as $item){
                    echo "<div class='col-md-3 col-sm-6'>";
                        echo "<div class='thumbnail item-box'>";
                            echo"<span class='price-tag'>$". $item['Price'] . "</span>";
                            echo"<img src='uploaded\itemImg\\".$item['Image']."' alt='Item For Image' />";
                            echo "<div class='caption'>";
                                echo "<h3><a href='item.php?itemid=". $item['Item_ID']."'>". ucfirst($item['Name']) ."</a></h3>";
                                echo "<p>". ucfirst($item['Description']) ."</p>";
                                echo "<div class='date'>". $item['Add_Date'] ."</div>";
                            echo "</div>";
                        echo "</div>";
                    echo "</div>";
                }
            }else{
                echo "<div class='alert alert-danger'>You Must Add Page ID </div>";
            }
        ?>
    </div>
</div>
    
    
<?php 
   
    include  $tpl . 'footer.php';
?>