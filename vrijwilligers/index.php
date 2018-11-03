<?php
session_start();
 

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$rol = (string)$_SESSION["rol"];
if($rol == "v") {
} elseif($rol == "a"){
header("location: admin.php");
exit;
} else {
$_SESSION = array();
session_destroy();
header("location: login.php");
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
    <title>Welcome</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
    <div class="page-header">
        <h1>Hallo, <b><?php echo htmlspecialchars($_SESSION["voornaam"]) . " " . htmlspecialchars($_SESSION["achternaam"]); ?></b>. welkom bij Emma Helpt. <br/>
		</h1>
		<div style="width:100%;heigth:300px;background-color:#ADADAD">
			<?php
			$result = mysqli_query($link,"SELECT * FROM aanvragen WHERE vrijwilliger='0' ORDER BY datum");


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
			echo "<form action='neemaan.php' method='post'>";
			echo "<input type='submit' class='btn btn-primary' name='".$row['id']."' value='Neem taak aan' style='position:absolute;bottom:40px;left:60px; transform: rotate(-3deg);'>";
			echo "</form>";
			echo "</div>";
			}

			mysqli_close($link);
			?>
		<div style="clear: both;padding-top:10px;width:100%;"></div>
		</div>
    </div>

    <p>
        <a href="alleaanvragen.php" class="btn btn-primary">Zie alle aanvragen</a>
		<a href="mijnaanvragen.php" class="btn btn-primary">Mijn geaccepteerde aanvragen</a>
        <a href="logout.php" class="btn btn-danger">Uitloggen</a>
    </p>
</body>
</html>