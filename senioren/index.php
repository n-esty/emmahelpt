<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
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
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hallo, <b><?php echo htmlspecialchars($_SESSION["naam"]); ?></b>, maak aub een keuze:</h1>
    </div>
    <p>
        <a href="stickers.php" class="btn btn-warning">Doe een nieuwe aanvraag</a>
        <a href="openaanvragen.php" class="btn btn-danger">Bekijk open aanvragen</a>
    </p>
</body>
</html>