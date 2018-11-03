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

?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Open aanvragen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hier zijn uw open aanvragen, <b><?php echo htmlspecialchars($_SESSION["naam"]) ?></b> <br/>
		</h1>
		<div style="width:100%;heigth:300px;background-color:#ADADAD">
			<?php
			$naam_senior = $_SESSION['naam'];

			$result = mysqli_query($link,"SELECT * FROM aanvragen WHERE naam='$naam_senior' ORDER BY datum");


			while($row = mysqli_fetch_array($result))
			{
			echo "<div style='float:left;margin-left:20px;margin-top:0px;margin-bottom:0px;height:270px;width:240px;background-image:url(postit.png);background-size:contain;position:relative;'>";
			echo "<table width='100%' heigth='100%' style='margin-top:70px;padding:5px;text-align:left;margin-left:21px;transform: rotate(-3deg);'>";
			echo "<tr><td>Naam:</td><td>" . $row['naam'] . "</td></tr>";
			echo "<tr><td>Locatie:</td><td>" . $row['locatie'] . "</td></tr>";
			echo "<tr><td>Datum:</td><td>" . $row['datum'] . "</td></tr>";
			echo "<tr><td>Tijd:</td><td>" . $row['tijd'] . "</td></tr>";
			echo "<tr><td>Taak:</td><td>" . $row['taak'] . "</td></tr>";
			echo "</table>";
			if($row['vrijwilliger'] == '0') {
			echo "<a class='btn btn-primary' style='position:absolute;bottom:40px;left:60px; transform: rotate(-3deg);'>Aanvraag open</a>";
			} else {
			echo "<a class='btn btn-danger' style='position:absolute;bottom:40px;left:60px; transform: rotate(-3deg);'> Door: " . $row['vrijwilliger'] . "</a>";
			}		
			echo "</div>";
			}

			mysqli_close($link);
			?>
		<div style="clear: both;padding-top:10px;width:100%;"></div>
		</div>
    </div>

    <p>
        <a href="stickers.html" class="btn btn-danger">Nieuwe aanvraag aanmaken</a>
    </p>
</body>
</html>