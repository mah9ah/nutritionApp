<?php
include 'db_connect.php';
$activeNav = 'dashboard';

// Get dashboard statistics
$totalRecipes = $conn->query("SELECT COUNT(*) as count FROM recipe")->fetch_assoc()['count'];
$lastWeekRecipes = $conn->query("SELECT COUNT(*) as count FROM recipe WHERE updated >= DATE_SUB(NOW(), INTERVAL 7 DAY)")->fetch_assoc()['count'];

// Get recent recipes
$recentRecipes = $conn->query("SELECT id, name, minutes, rating, description FROM recipe ORDER BY updated DESC LIMIT 3");

$content = 'dashboard_content.php';
include 'layout.php';
?>