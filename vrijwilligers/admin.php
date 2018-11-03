<?php
// Include config file
require_once "config.php";

 
// Define variables and initialize with empty values
$clientnummer = $password = $confirm_password = "";
$clientnummer_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate clientnummer
    if(empty(trim($_POST["clientnummer"]))){
        $clientnummer_err = "Please enter a clientnummer.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM senioren WHERE clientnummer = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_clientnummer);
            
            // Set parameters
            $param_clientnummer = trim($_POST["clientnummer"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $clientnummer_err = "This clientnummer is already taken.";
                } else{
                    $clientnummer = trim($_POST["clientnummer"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

     // Validate naam
    if(empty(trim($_POST["naam"]))){
        $naam_err = "Please enter a naam.";
    } else{
        $naam = trim($_POST["naam"]);
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) != 4){
        $password_err = "Pincode moet 4 nummers zijn.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    if(empty($clientnummer_err) && empty($naam_err) && empty($password_err) && empty($confirm_password_err)){
        
        $sql = "INSERT INTO senioren (clientnummer, naam, password) VALUES (?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            mysqli_stmt_bind_param($stmt, "sss", $param_clientnummer, $param_naam, $param_password);
            
            $param_clientnummer = $clientnummer;
            $param_naam = $naam;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            if(mysqli_stmt_execute($stmt)){

                header("location: admin.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
        mysqli_stmt_close($stmt);
    }
    

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
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Client Toevoegen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 450px; padding:20px;margin-left:auto;margin-right:auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Nieuwe client <br/>toevoegen</h2>
        <p>&nbsp;</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($clientnummer_err)) ? 'has-error' : ''; ?>">
                <label>clientnummer</label>
                <input type="text" name="clientnummer" class="form-control" value="<?php echo $clientnummer; ?>">
                <span class="help-block"><?php echo $clientnummer_err; ?></span>
            </div>   
            <div class="form-group <?php echo (!empty($naam_err)) ? 'has-error' : ''; ?>">
                <label>naam</label>
                <input type="text" name="naam" class="form-control" value="<?php echo $naam; ?>">
                <span class="help-block"><?php echo $naam_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Pincode</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Pincode</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Toevoegen">
                <a href="vrijwilligers.php" class="btn btn-default">Vrijwilligers lijst</a>
                <a href="logout.php" class="btn btn-danger">Uitloggen</a>

            </div>
        </form>
    </div>    
</body>
</html>