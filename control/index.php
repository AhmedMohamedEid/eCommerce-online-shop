<?php
    session_start();
    
    // if Session is Register in page transtion  Redirect in  Dashboard page 
    if(isset($_SESSION['Admin_login'])){
        header('Location: dashboard.php'); // Register to dashboard Page
    }
    $nonavbar = ""; 
    $pageTitle = 'Login';

    include 'init.php';
    // Check If User Comming From HTTP POST Request 
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        
        $username   = filter_var( $_POST['username'] , FILTER_SANITIZE_STRING );
        $password   = $_POST['password'];
        $hashedpass = sha1($password);
        
        // Check If User is exist in Database
         $stmt = $conect->prepare('SELECT User_ID, Username ,Password
                                     FROM users
                                     WHERE Username=?
                                     AND Password=?
                                     AND Group_ID = 1
                                     LIMIT 1 ');
        $stmt ->execute(array($username , $hashedpass));
        $row = $stmt ->fetch();
        $count = $stmt->rowCount();
        
        
            // if Count > 0 this is user isset In Database
            if($count > 0){
                $_SESSION['Admin_login'] = $username ; // Register Session Name
                $_SESSION['ID'] = $row['User_ID']; // Register Session User ID
                header('Location: dashboard.php'); // Register to dashboard Page
                exit();
            }
        
    }
?>
    
    
    <form class="login" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <div class="text-center"><i class="fa fa-user-circle-o fa-4x " aria-hidden="true"></i></div>
        <h4 class="text-center">Dashboard Login</h4>
        
        <div class="form-group">
            <input id= "username" class="form-control" type="username" name="username" placeholder="Usernam" autocomplete="off"  />
            <i class="fa fa-user-o" aria-hidden="true"></i>
            <div class='alert alert-danger user-error form-error'> <i class="fa fa-info "></i> the Username Is less Than 4 </div>
        </div>
         
         
        <div class="form-group">
            <input id ="pass" class="form-control col-md-8" type="password" name="password" placeholder="Password" autocomplete="new-password"/>
            <i class="fa fa-key" aria-hidden="true"></i>
            <div class='alert alert-danger form-error '> <i class="fa fa-info "></i>  Password Is Rong</div> 
        </div>
        
        
        <div class="form-group text-center">        
            <input class="btn btn-primary col-md-8 btn-block" type="submit" value="Login"/>
            <i class="fa fa-sign-in" aria-hidden="true"></i>
        </div>
    </form>
    
<?php
    include  $tpl . 'footer.php';
?>