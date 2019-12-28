<?php
    ob_start();
    session_start();
    $pageTitle = 'Add New Product';
    include 'init.php';
    if(isset($_SESSION['Login'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            
            $formErrors = array();
            
            $title      = filter_var($_POST['name'] , FILTER_SANITIZE_STRING);
            $desc       = filter_var($_POST['description'] , FILTER_SANITIZE_STRING);
            $price      = filter_var($_POST['price'] , FILTER_SANITIZE_NUMBER_INT);
            $country    = filter_var($_POST['country_made'] , FILTER_SANITIZE_STRING );
            $status     = filter_var($_POST['status'] , FILTER_SANITIZE_NUMBER_INT);
            $category   = filter_var($_POST['categories'] , FILTER_SANITIZE_NUMBER_INT );
			$tags	    = filter_var($_POST['tags'] , FILTER_SANITIZE_STRING );
            
            if(strlen($title) < 4){
                $formErrors []  = ' Item Title Must Be At Least 4 Characters';
            }
            if(strlen($desc) < 10){
                $formErrors []  = ' Item Description Must Be At Least 10 Characters';
            }
            if(strlen($country) < 2){
                $formErrors []  = ' Item Country Must Be At Least 2 Characters';
            }
            if(empty($price)){
                $formErrors []  = ' Item Price Must Be Not Empty';
            }
            if(empty($status)){
                $formErrors []  = ' Item Status Must Be Not Empty';
            }
            if(empty($category)){
                $formErrors []  = ' Item Category Must Be Not Empty';
            }
            
            
			if (empty($formErrors)){
				
				// Insert User Info In Database
				$stmt = $conect->prepare( " INSERT INTO   items( Name, Description , Price, Country_Made , Status , Add_Date , Cat_ID , Member_ID , Tags)
											VALUES (  :name ,:desc  , :price , :country , :status , now() , :cat , :member , :tags)");
				$stmt->execute(array( 
						'name'		=> $title,
						'desc' 		=> $desc,
						'price' 	=> $price,
						'country'	=> $country,
						'status'	=> $status,
						'cat'		=> $category,
						'member'	=> $_SESSION['UserID'],
						'tags'		=> $tags
				));
				if($stmt){
					$successMsg ='The Item has been Added';
                }
			}
				
	 	}
		
        
?>
<h1 class="text-center"> <?php echo $pageTitle ?></h1>
<div class="creat-ad block">
    <div class="container">
        <div>
            <div class="">
                <div class="row">
                    <div class="col-md-8">
                        <form class="form-horizontal" action="<?php echo $_SERVER['PHP_SELF']  ?>" method="POST">
                        <!-- Start Name -->
                            <div class="form-group">
                                <input 
                                    class="input"
                                    type="text" 
                                    name="name" 
                                    autocomplete='off' 
                                    pattern=.{4,} 
                                    placeholder="Name Of The Item" 
                                    required
                                    title="This Field Require At Least 4 Character" />
                            </div>
                        <!-- End Name -->
                        <!-- Start Description -->
                            <div class="form-group">
                                <input 
                                    class="input"
                                    type="text" 
                                    name="description" 
                                    autocomplete='off' 
                                    pattern=.{4,} 
                                    placeholder="Description of Item" 
                                    required
                                    title="This Field Require At Least 10 Character" />
                            </div> 
                        <!-- End Description -->
                        <!-- Start Price -->
                            <div class="form-group">
                                <input 
                                    class="input"
                                    type="text" 
                                    name="Price" 
                                    pattern=.{4,} 
                                    placeholder="Price of Item" 
                                    required
                                    title="This Field Require At Least 10 Character" />
                            </div> 
                        <!-- End Price -->
                        <!-- Start Country Made -->
                            <div class="form-group">
                                <input 
                                    class="input"
                                    type="text" 
                                    name="country_made"  
                                    placeholder="Country Made of Item" 
                                    required />
                            </div> 
                        <!-- End Country Made -->

                        <!-- Start Status -->
                            <div class="form-group">
                                <select class="input" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="1">New</option>
                                    <option value="2">Like New</option>
                                    <option value="3">Used</option>
                                    <option value="4">Very Old</option>
                                </select>
                            </div>
                        <!-- End Status -->
                        <!-- Start brand -->
                            <div class="form-group">
                                <select class="input" name="brand">
                                    <option value="">Select Brand</option>
                                    <?php
                                        $brands = getAllFrom('*','brand', '' ,'', 'brand_id');
                                        foreach($brands as $brand){
                                            echo "<option value='". $brand['brand_id'] ."'>". $brand['brand_name'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        <!-- End brand -->
                        <!-- Start Categories -->
                            <div class="form-group">
                                <select class="input" name="categories">
                                    <option value="">Select Catergory</option>
                                    <?php
										$cats = getAllFrom('*','Categories', '' ,'', 'Cat_ID');
                                        foreach($cats as $cat){
                                            echo "<option value='". $cat['Cat_ID'] ."'>". $cat['Name'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        <!-- End Categories -->
						<!-- Start Tags Made -->
							<div class="form-group form-group-lg">
									<input type="text" name="tags" class="input"   placeholder="separate Tag with Comma (,)" />
							</div>
						<!-- End Tags Made -->
                        <!-- Start Submit -->
                            <div class="form-group form-group-lg">
                                <div class="col-sm-offset-3 col-sm-9">
                                    <input type="submit" value="Add Item" class="btn btn-danger btn-md">
                                </div>
                            </div>
                        <!-- End Submit -->
                        </form>	
                             
                    </div>
                    <div class="col-md-4">
                        <div class='thumbnail item-box live-preview'>
                            <span class='price-tag'>$<span class="live-price">0</span></span>
                            <img src='layout/images/image.png' alt='Item For Image' />
                            <div class='caption'>
                                <h3><a href='#' class="live-title">Title</a></h3>
                                <p class="live-desc">Description</p>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Start Panel Error  -->
                <div class="the-Massage">
                    <?php
                        if(!empty($formErrors)){
                           foreach($formErrors as $error){
                               echo '<div class="alert alert-danger">' . $error . '</div>';
                           }
                        }
						if(isset($successMsg)){
							echo '<div class="alert alert-success text-center">' . $successMsg . '</div>'; 
						}
                    ?>
                </div>
                <!-- Start Panel Error  -->
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