<?php
require_once '../includes/session.php';

// Clear session
$_SESSION = [];
session_destroy();

// Redirect to Sign In page
header("Location: signin.php");
exit();
?>
