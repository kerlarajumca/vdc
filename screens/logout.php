<?php
session_start(); // Start the session

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other page of your choice
header("Location: ../index.php");
exit();
?>