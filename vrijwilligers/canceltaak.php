<?php
session_start();
$name = "";
require_once "config.php";
foreach($_POST as $name => $content) { 
}
   $sql = "UPDATE aanvragen SET vrijwilliger = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_vrijwilliger, $param_id);
            
            // Set parameters
            $param_id = $name;
            $param_vrijwilliger = '0';
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                header("location:mijnaanvragen.php");
                exit();
            } else{
                echo $param_username;
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
?>