<?php
// Config include
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $voornaam = $achternaam = $adres = $telnr = $email = $password = $confirm_password = "";
$username_err = $voornaam_err = $achternaam_err = $adres_err = $telnr_err = $email_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Vul aub een gebruikersnaam in.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM vrijwilligers WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Deze gebruikersnaam is al in gebruik.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "USERNAME! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate voornaam
    if(empty(trim($_POST["voornaam"]))){
        $voornaam_err = "Vul aub een voornaam in.";
    } else{
        $voornaam = trim($_POST["voornaam"]);
    }

 // Validate achternaam
    if(empty(trim($_POST["achternaam"]))){
        $achternaam_err = "Vul aub een achternaam in.";
    } else{
        $achternaam = trim($_POST["achternaam"]);
    }


 // Validate adres
    if(empty(trim($_POST["adres"]))){
        $adres_err = "Vul aub een adres in.";
    } else{
        $adres = trim($_POST["adres"]);
    }


 // Validate telnr
    if(empty(trim($_POST["telnr"]))){
        $telnr_err = "Vul aub een telefoonnummer in.";
    } else{
        $telnr = trim($_POST["telnr"]);
    }


 // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Vul aub een email adres in.";
    } else{
        $email = trim($_POST["email"]);
    }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Vul aub een wachtwoord in.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Wachtwoorden moeten uit minstens 6 tekens bestaan.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Vul uw wachtwoord nogmaals in.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Wachtwoorden komen niet overeen.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($voornaam_err) && empty($achternaam_err) && empty($adres_err) && empty($telnr_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO vrijwilligers (username, voornaam, achternaam, adres, telnr, email, password) VALUES (?, ?, ? ,?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssssss", $param_username, $param_voornaam, $param_achternaam, $param_adres, $param_telnr, $param_email, $param_password);
            // Set parameters
            $param_username = $username;
            $param_voornaam = $voornaam;
            $param_achternaam = $achternaam;
            $param_adres = $adres;
            $param_email = $email;
            $param_telnr = $telnr;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{

                echo "GENERAL! Something went wrong. Please try again later.";
                echo $param_achternaam;
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
    <title>Aanmelden als vrijwilliger</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{width: 450px; padding:20px;margin-left:auto;margin-right:auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Vrijwilligers account<br /> aanmaken</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Gebruikersnaam</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    


            <div class="form-group <?php echo (!empty($voornaam_err)) ? 'has-error' : ''; ?>">
                <label>Voornaam</label>
                <input type="text" name="voornaam" class="form-control" value="<?php echo $voornaam; ?>">
                <span class="help-block"><?php echo $voornaam_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($achternaam_err)) ? 'has-error' : ''; ?>">
                <label>Achternaam</label>
                <input type="text" name="achternaam" class="form-control" value="<?php echo $achternaam; ?>">
                <span class="help-block"><?php echo $achternaam_err; ?></span>
            </div>    

            <div class="form-group <?php echo (!empty($adres_err)) ? 'has-error' : ''; ?>">
                <label>Adres</label>
                <input type="text" name="adres" class="form-control" value="<?php echo $adres; ?>">
                <span class="help-block"><?php echo $adres_err; ?></span>
            </div>  

                        <div class="form-group <?php echo (!empty($telnr_err)) ? 'has-error' : ''; ?>">
                <label>Telefoon nummer</label>
                <input type="text" name="telnr" class="form-control" value="<?php echo $telnr; ?>">
                <span class="help-block"><?php echo $telnr_err; ?></span>
            </div>  

            <div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
                <label>E-mail</label>
                <input type="text" name="email" class="form-control" value="<?php echo $email; ?>">
                <span class="help-block"><?php echo $email_err; ?></span>
            </div>  

            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Wachtwoord herhalen</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Aanmelden">
                <input type="reset" class="btn btn-default" value="Reset">
            </div>
            <p>Heb je al een account? <a href="login.php">Log hier in</a>.</p>
        </form>
    </div>    
</body>
</html>