<?php
// Start the session
session_start();

// Clear all session variables
session_unset();

// Destroy the session
session_destroy();

// Redirect to home.php
header("Location: ../Home.php");
exit();
?>
