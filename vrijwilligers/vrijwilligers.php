<?php
// Sessie starten
session_start();
 
// Login check en user permission check
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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vrijwilligers lijst</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 95vw; padding:20px;margin-left:auto;margin-right:auto; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Vrijwilligers</h2>

<?php
$result = mysqli_query($link,"SELECT * FROM vrijwilligers");

echo "<table border='1'>
<tr>
<th>Gebruikersnaam</th>
<th>Voornaam</th>
<th>Achternaam</th>
<th>Adres</th>
<th>Telefoon nummer</th>
<th>Email</th>
<th>Verified</th>
</tr>";

while($row = mysqli_fetch_array($result))
{
echo "<tr>";
echo "<td>" . $row['username'] . "</td>";
echo "<td>" . $row['voornaam'] . "</td>";
echo "<td>" . $row['achternaam'] . "</td>";
echo "<td>" . $row['adres'] . "</td>";
echo "<td>" . $row['telnr'] . "</td>";
echo "<td>" . $row['email'] . "</td>";
echo "<td>" . $row['verified'] . "</td>";
echo "</tr>";
}
echo "</table>";

mysqli_close($link);
?><p></p>
				<a href="admin.php" class="btn btn-primary">Terug</a>
                <a href="verify.php" class="btn btn-default">Verify vrijwilliger</a>
                <a href="logout.php" class="btn btn-danger">Uitloggen</a>
    </div>    
</body>
</html>
