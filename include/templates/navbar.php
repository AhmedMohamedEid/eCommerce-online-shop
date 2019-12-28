
<!--  End Upper Bar --

<nav class="navbar navbar-inverse">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-nav" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="index.php">Home Page</a>
    </div>
    <div class="collapse navbar-collapse " id="app-nav">
      <ul class="nav navbar-nav navbar-right">
        <?php/* 
          $cats =  getAllFrom('*' , 'categories' , 'WHERE Parent = 0' , '' , 'Cat_ID' , 'ASC');
          foreach($cats as $cat){
            echo "<li>
                    <a href='categories.php?pageid=". $cat['Cat_ID'] ."'>"
                      . $cat['Name'] .  "
                    </a>
                  </li>";
         */ }
        ?>
      </ul>
    </div>
  </div>
</nav> -->


<!-- HEADER -->
    <header>
      <!-- TOP HEADER -->
      <div id="top-header">
        <div class="container">
          <ul class="header-links pull-left">
            <li><a href="#"><i class="fa fa-phone"></i> +021-95-51-84</a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i> email@email.com</a></li>
            <li><a href="#"><i class="fa fa-map-marker"></i> 1734 Stonecoal Road</a></li>
          </ul>


      <?php 
        if (isset($_SESSION['Login'])){ ?>
          <?php
             $stmt = $conect ->prepare(" SELECT Image_Profile FROM users WHERE User_ID = {$_SESSION['UserID']} ");
                $stmt->execute();
                $get = $stmt->fetch();
          ?>
          <div class="user-session dropdown text-right">
                  <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">    
                    <?php 
                      if(empty($get['Image_Profile'])){
                        echo '<img src="././layout/images/avatar.png">';
                      }else{
                        ?> <img src="././uploaded/imageProfile/<?=$get['Image_Profile']; ?>">
                     <?php } 
                    ?>
                    <span><?=$_SESSION['Login']?></span>
                  </a>
                  <div class="dropdown-list text-left">
                    <ul class="list">
                      <li class="page-list"><a href='#'>My Profile</a></li>
                      <li class="page-list"><a href='newproduct.php'>New Product</a></li>
                      <li class="page-list"><a href='#'>Carts</a></li>
                      <li class="page-list"><a href='#'>My Items</a></li>
                      <li class="page-list"><a href='logout.php'>Logout</a></li>
                    </ul>
                </div>


        <?php }else{ ?>
          <ul class="header-links pull-right">
            <li><a href="#"><i class="fa fa-dollar"></i> USD</a></li>
            <li><a href="login.php"><i class="fa fa-user-o"></i> Login</a></li>
          </ul>
      <?php } ?>
        </div>
      </div>
      <!-- /TOP HEADER -->

      <!-- MAIN HEADER -->
      <div id="header">
        <!-- container -->
        <div class="container">
          <!-- row -->
          <div class="row">
            <!-- LOGO -->
            <div class="col-md-3">
              <div class="header-logo">
                <a href="index.php" class="logo">
                  <img src="<?=$imglayout ?>logo.png" alt="Electronice">
                </a>
              </div>
            </div>
            <!-- /LOGO -->

            <!-- SEARCH BAR -->
            <div class="col-md-6">
              <div class="header-search">
                <form>
                  <select class="input-select">
                    <option value="0">All Categories</option>
                    <option value="1">Category 01</option>
                    <option value="1">Category 02</option>
                  </select>
                  <input class="input" placeholder="Search here">
                  <button class="search-btn">Search</button>
                </form>
              </div>
            </div>
            <!-- /SEARCH BAR -->

            <!-- ACCOUNT -->
            <div class="col-md-3 clearfix">
              <div class="header-ctn">
                <!-- Wishlist -->
                <div>
                  <a href="#">
                    <i class="fa fa-heart-o"></i>
                    <span>Your Wishlist</span>
                    <div class="qty">2</div>
                  </a>
                </div>
                <!-- /Wishlist -->

                <!-- Cart -->
                <div class="dropdown">
                  <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Your Cart</span>
                    <div class="qty">3</div>
                  </a>
                  <div class="cart-dropdown">
                    <div class="cart-list">
                      <div class="product-widget">
                        <div class="product-img">
                          <img src="././layout/images/product01.png" alt="">
                        </div>
                        <div class="product-body">
                          <h3 class="product-name"><a href="#">product name goes here</a></h3>
                          <h4 class="product-price"><span class="qty">1x</span>$980.00</h4>
                        </div>
                        <button class="delete"><i class="fa fa-close"></i></button>
                      </div>

                      <div class="product-widget">
                        <div class="product-img">
                          <img src="././layout/images/product02.png" alt="">
                        </div>
                        <div class="product-body">
                          <h3 class="product-name"><a href="#">product name goes here</a></h3>
                          <h4 class="product-price"><span class="qty">3x</span>$980.00</h4>
                        </div>
                        <button class="delete"><i class="fa fa-close"></i></button>
                      </div>
                    </div>
                    <div class="cart-summary">
                      <small>3 Item(s) selected</small>
                      <h5>SUBTOTAL: $2940.00</h5>
                    </div>
                    <div class="cart-btns">
                      <a href="#">View Cart</a>
                      <a href="#">Checkout  <i class="fa fa-arrow-circle-right"></i></a>
                    </div>
                  </div>
                </div>
                <!-- /Cart -->

                <!-- Menu Toogle -->
                <div class="menu-toggle">
                  <a href="#">
                    <i class="fa fa-bars"></i>
                    <span>Menu</span>
                  </a>
                </div>
                <!-- /Menu Toogle -->
              </div>
            </div>
            <!-- /ACCOUNT -->
          </div>
          <!-- row -->
        </div>
        <!-- container -->
      </div>
      <!-- /MAIN HEADER -->
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
      <!-- container -->
      <div class="container">
        <!-- responsive-nav -->
        <div id="responsive-nav">
          <!-- NAV -->
          <ul class="main-nav nav navbar-nav">
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="#">Hot Deals</a></li>
            <li><a href="#">Categories</a></li>
            <li><a href="#">Laptops</a></li>
            <li><a href="#">Smartphones</a></li>
            <li><a href="#">Cameras</a></li>
            <li><a href="#">Accessories</a></li>
          </ul>
          <!-- /NAV -->
        </div>
        <!-- /responsive-nav -->
      </div>
      <!-- /container -->
    </nav>
    <!-- /NAVIGATION -->