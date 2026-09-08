<?php
// 1. Initialize or resume the current session
session_start();

// 2. Clear all session variables from memory
$_SESSION = array();

// 3. Clear the session cookie from the user's browser
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(), 
        '', 
        time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

// 4. Destroy the session on the server
session_destroy();

// 5. Redirect the user to the login or home page
header("Location: login.php");
exit;
?>
