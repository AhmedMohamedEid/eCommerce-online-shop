<?php
    ob_start();
    session_start();
    $pageTitle = 'Login';
    
    if (isset($_SESSION['Login'])){
        header('location: index.php');
    }
    include 'init.php';
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' ){
        if(isset($_POST['login'])){ # Form Login
            $username = $_POST['username'];
            $password = $_POST['password'];
            $hashedpass = sha1($password);
            
            $stmt = $conect ->prepare(" SELECT User_ID , Username , Password FROM users WHERE Username = ? AND Password = ?");
            $stmt->execute(array ($username , $hashedpass));
            $get = $stmt->fetch();
            $count = $stmt->rowCount();
            
            if($count > 0 ){
                $_SESSION['Login'] = $username ;
				$_SESSION['UserID'] = $get['User_ID'];
                header('location: index.php');
                exit();
            }
        }else{ # Form  Signup
            $formError = array();
            
            $user       =  $_POST['username'];
            $password   =  $_POST['password'];
            $password2  =  $_POST['password2'];
            $email      =  $_POST['email'];
            
            if (isset($user)){
                $filteredUser = filter_var($user , FILTER_SANITIZE_STRING);
                if(strlen($filteredUser) < 4 ){
                    $formError [] = 'Username Must be larger than <strong>4</strong> characters';
                }
            }
            if(isset($password) && isset($password2)){
                if (empty($password)){
                    $formError[] = "Sorry The Password Cant Be <strong>Empty</strong>";
                }
                
                if(sha1($password) !== sha1($password2)){
                    $formError[] = "Sorry The Password Not Identical";
                }
            }
            if(isset($email)){
                    if(empty($email)){
                        $formError [] = 'The Email cant be <strong>Empty</strong>';
                    }else{
                        $filteredEmail = filter_var($email , FILTER_SANITIZE_EMAIL);
                        
                        if(filter_var($filteredEmail , FILTER_VALIDATE_EMAIL) != true){
                            $formError [] = 'The Email is not Valid'; 
                        }
                    }
            }
            // Check if There is no database proceed the Update Operation ----***** 
			   if (empty($formErrors)){
					
					$check = checkItem("Username" , "users" , $user );
					if($check == 1){
						$formError [] = "Sorry This User Is Exist";
                         
					}else{ 
						// Update The Data Name With Info
					   $stmt = $conect -> prepare('INSERT INTO users  (Username , Password , Email, Regstatus ,Date )
                                                    VALUES(:iname , :ipass ,:iemail , 0 , now())');
					   $stmt->execute(array(
                                           'iname' => $user ,
                                           'ipass' => sha1($password),
                                           'iemail' =>$email ,
                                             ));
					   //echo Success Message
					   
					  $successMsg = "Congatsulation ! You are now Registered User";
						
					}
                }   
        }
    }
    
?>
<div class="container login-page">
    <h1 class="text-center">
        <span class="active" data-class='login' >Login</span> | <span data-class="signup">SignUp</span>
    </h1>

    <!-- Start Login Form -->
    <form class='login' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
        <div class="form-group">
            <input class="input" type="text" name="username" autocomplete='off' placeholder="Username">
        </div>
        <div class="form-group">
            <input class="input" type="password" name="password" placeholder="Password" autocomplete='new-password'/>
        </div>
        <div class="form-group">
             <input class='btn btn-danger' name="login" type='submit' value="Login" >
        </div>
      
    </form>

    <!-- End Login Form -->




    <!-- Start Signup Form -->
    <form class='signup' action='<?php echo $_SERVER['PHP_SELF']; ?>' method='POST'>
        <div class="form-group">
            <input class='input' name='username' type='text' autocomplete='off' placeholder="Enter Username" pattern='.{4,15}' title="Username Minimum 4 Char Maxmum 15 char"  required >
        </div>
        <div class="form-group">
            <input class='input' name='email' type='email' placeholder="Enter Your Email">
        </div>
        <div class="form-group">
            <input class='input' name='password' type='password' autocomplete='new-password' placeholder="Enter Password" minlength="4" required >
        </div>
        <div class="form-group">
            <input class='input' name='password2' type='password' autocomplete='new-password' placeholder="Enter Password again" minlength="4" required >
        </div>
        <div class="form-group">
            <input class='btn btn-danger' name="signup" type='submit' value="Signup" >
        </div>
    </form>
    <!-- End Signup Form -->
    <!-- Start The Error Msg -->
    <div class="the-errors text-center">
        <?php
        if(!empty($formError)){
            foreach($formError as $error){
                echo '<div class="alert alert-danger">' . $error . '</div>';
            }
        }
        if(isset($successMsg)){
            echo '<div class="alert alert-success">' . $successMsg . '</div>'; 
        }
        ?>
    </div>
    <!-- end The Error Msg -->
</div>


<?php
    include $tpl .'footer.php';
    ob_end_flush();
?>