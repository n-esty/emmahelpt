<?php
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$rol = (string)$_SESSION["rol"];
if($rol == "s") {
} elseif($rol == "a"){
header("location: ../vrijwilligers/admin.php");
exit;
} else {
$_SESSION = array();
session_destroy();
header("location: ../senioren/login.php");
exit;
}

 
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$locatie = $datum = $tijd = $activiteit = "";
$locatie_err = $datum_err = $tijd_err = $activiteit_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 

    if(empty(trim($_POST["locatie"]))){
        $locatie_err = "Please enter a locatie.";
    } else{
        $locatie = trim($_POST["locatie"]);
    }

    if(empty(trim($_POST["datum"]))){
        $datum_err = "Geef aub een datum aan.";
    } else{
        $datum = trim($_POST["datum"]);
    }   
	if(empty(trim($_POST["tijd"]))){
        $tijd_err = "Geef aub een tijd aan.";
    } else{
        $tijd = trim($_POST["tijd"]);
    }


    if(empty(trim($_POST["activiteit"]))){
        $activiteit_err = "Please enter a activiteit.";
    } else{
        $activiteit = trim($_POST["activiteit"]);
    }

    
    // Check input errors before inserting in database
    if(empty($locatie_err) && empty($datumtijd_err) && empty($activiteit_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO aanvragen (naam, locatie, datum, tijd, taak) VALUES (?, ?, ?, ? ,?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssss", $param_naam, $param_locatie, $param_datum, $param_tijd, $param_taak);
            // Set parameters
            $param_naam = $_SESSION['naam'];
            $param_locatie = $locatie;
            $param_datum = $datum;
            $param_tijd = $tijd;
            $param_taak = $activiteit;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: login.php");
            } else{

                echo "GENERAL! Something went wrong. Please try again later.";
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
        <h2>Activiteit aanvragen</h2>
        <form id="aanvraagForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?activiteit=test" method="post">
            <div class="form-group <?php echo (!empty($locatie_err)) ? 'has-error' : ''; ?>">
                <label>Locatie</label>
                <input type="text" name="locatie" class="form-control" value="<?php echo $locatie; ?>">
                <span class="help-block"><?php echo $locatie_err; ?></span>
            </div>    


            <div class="form-group <?php echo (!empty($datumtijd_err)) ? 'has-error' : ''; ?>">
                <label>Datum</label>
                <input type="date" name="datum" class="form-control" value="<?php echo $datum; ?>">
                <span class="help-block"><?php echo $datum_err; ?></span>
            </div>           
			<div class="form-group <?php echo (!empty($tijd_err)) ? 'has-error' : ''; ?>">
                <label>Tijd</label>
                <input type="text" name="tijd" class="form-control" value="<?php echo $tijd; ?>">
                <span class="help-block"><?php echo $tijd_err; ?></span>
            </div>
			
			


            <div class="form-group <?php echo (!empty($activiteit_err)) ? 'has-error' : ''; ?>">
                <label>Activiteit</label>
                <input type="text" name="activiteit" class="form-control" value="<?php echo $activiteit; ?>">
                <span class="help-block"><?php echo $activiteit_err; ?></span>
            </div>    
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Aanvraag indienen">
            </div>
        </form>
    </div>    
</body>
    <script>
        var hashParams = window.location.hash.substr(1).split('&'); // substr(1) to remove the `#`
        var params = hashParams.toString();
        var res = params.split("=");
        console.log(res[0]);
        var decoded = decodeURI(res[1]);
        document.getElementById("aanvraagForm").elements[res[0]].value=decoded;
</script>
</html>