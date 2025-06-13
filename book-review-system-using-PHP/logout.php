<?php
session_start();
session_unset();    // Unset all session variables
session_destroy();  // Destroy the session

// Redirect to home or login page
header("Location: index"); // Change to login_user.php or login_author.php if preferred
exit();
