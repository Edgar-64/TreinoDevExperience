<?php
// 1. Initialize or resume the current session
session_start();

// 2. Clear all session variables from memory
$_SESSION = array();


// 4. Destroy the session on the server
session_destroy();

// 5. Redirect the user to the login or home page
header("Location: login.php");
exit;
?>