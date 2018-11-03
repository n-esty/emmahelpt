
<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$clientnummer = $password = "";
$clientnummer_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if clientnummer is empty
    if(empty(trim($_POST["clientnummer"]))){
        $clientnummer_err = "Please enter clientnummer.";
    } else{
        $clientnummer = trim($_POST["clientnummer"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($clientnummer_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, naam, rol, clientnummer, password FROM senioren WHERE clientnummer = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_clientnummer);
            
            // Set parameters
            $param_clientnummer = $clientnummer;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if clientnummer exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $naam, $rol, $clientnummer, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["rol"] = $rol;
							$_SESSION["naam"] = $naam;
                            $_SESSION["clientnummer"] = $clientnummer;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if clientnummer doesn't exist
                    $clientnummer_err = "No account found with that clientnummer.";
                }
            } else{
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
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inloggen Senioren</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 22px sans-serif; }
        .wrapper{ width: 450px; padding:20px;margin-left:auto;margin-right:auto;margin-top:calc(50vh - 200px); }
    </style>
</head>
<body>
    <div class="wrapper">
        <p>Uw senioren pagina, <br/>vul uw 'Emma Helpt' gegevens in<br/>&nbsp;</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($clientnummer_err)) ? 'has-error' : ''; ?>">
                <label>clientnummer</label>
                <input type="text" name="clientnummer" class="form-control" value="<?php echo $clientnummer; ?>">
                <span class="help-block"><?php echo $clientnummer_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>pincode</label>
                <input type="text" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login" style="font-size:24px;">
            </div>
        </form>
    </div>    
</body>
</html>