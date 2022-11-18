<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "db.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = $login_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, username, password, type FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $type);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            $logged_in_user = mysqli_fetch_assoc(true) ;
                            if ($logged_in_user['type'] == 1)
                            {
                                $_SESSION['user'] = $logged_in_user;
                                $_SESSION['success'] = "Welcome admin";
                                header('location: adminProducts.php');
                            }
                            //---------------------------------redirect to admin panel code here---------------
                        } else{
                            $_SESSION['user'] = $logged_in_user;
                            $_SESSION['success'] = "Welcome user";
                            header('location: index.php');
                            // Password is not valid, display a generic error message
                        }
                    }else{
                        $login_err = "Invalid username or password.";
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesnav.css">
    <title>Aisha's Cupcakes</title>
    
</head>
<?php
//include_once('navbar.php');
?>

<body>

    <form name="login" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
  <div class="container1">
    <h1>Login</h1>
    <p>Please fill in your login details below</p>

    <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

    <hr>

    <label for="loginemail"><b>Username</b></label>
    <input type="text" placeholder="Enter your username" class="form-control-login <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" name="username" id="username">
    <span class="invalid-feedback"><?php echo $username_err; ?></span>

    <label for="loginpsw"><b>Password</b></label>
    <input type="password" placeholder="Enter your password" class="form-control-login <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" name="password" id="password">
    <span class="invalid-feedback"><?php echo $password_err; ?></span>

    <button type="submit" class="btn" >Login</button>
  </div>

  <div class="container2">
    <p>Don't have an account? <a href="register.php">Register now</a>.</p>
  </div>

  <script type="text/javascript" src="validate.js"></script>
</form>


</body>
<?php
    include_once('footertest.php')
?>
</html>