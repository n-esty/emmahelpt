<?php
// Sessie starten
session_start();
 
// Login en permission check
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$rol = (string)$_SESSION["rol"];
if($rol == "a") {
}  else {
$_SESSION = array();
session_destroy();
header("location: index.php");
exit;
} 
 
// Config include
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $verify = "";
$username_err = $verify_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate gebruikersnaam
    if(empty(trim($_POST["username"]))){
        $username_err = "Voer een gebruikersnaam in.";     
    } else{
        $username = trim($_POST["username"]);
    }
    $verify = $_POST["verify"];
    
    
        
    // Check input errors before updating the database
    if(empty($username_err) && empty($verify_err)){
        // Prepare an update statement
        $sql = "UPDATE vrijwilligers SET verified = ? WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_verify, $param_username);
            
            // Set parameters
            $param_verify = $verify;
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                header("location: vrijwilligers.php");
                exit();
            } else{
                echo $param_username;
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 <?php
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$rol = (string)$_SESSION["rol"];
if($rol == "a") {
}  else {
$_SESSION = array();
session_destroy();
header("location: index.php");
exit;
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 450px; padding:20px;margin-left:auto;margin-right:auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Keur vrijwilliger goed</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
           <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($verify_err)) ? 'has-error' : ''; ?>">
                <label>Verify</label>
                <input type="checkbox" name="verify" class="form-control" value="1">
                <span class="help-block"><?php echo $verify_err; ?></span>
            </div> 

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Uitvoeren">
                <a class="btn btn-link" href="index.php">Cancel</a>
            </div>
        </form>
    </div>    
</body>
</html>