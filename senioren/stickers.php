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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kies een activiteit</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{width: 450px; padding:20px;margin-left:auto;margin-right:auto;}
    </style>

</head>
<body>
    <div class="wrapper">
        <h2>Kies een activiteit</h2>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Koffie Drinken'" class="btn btn-primary">Koffie drinken</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Tuinieren'" class="btn btn-primary">Tuinieren</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Bingo'" class="btn btn-primary">Bingo</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Kapper'" class="btn btn-primary">Kapper</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Boodschappen doen'" class="btn btn-primary">Boodschappen doen</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php#activiteit=Wandeling'" class="btn btn-primary">Wandeling</button></br>
				<button style="width:100%;margin-top:10px;padding:10px;font-size:18px;" onclick="window.location.href='nieuweaanvraag.php'" class="btn btn-primary">Iets anders</button>
            </div>
        </form>
    </div>    
</body>
</html>