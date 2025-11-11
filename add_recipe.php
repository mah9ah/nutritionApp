<?php
include 'db_connect.php';

$message = '';
$activeNav = 'recipes';

if ($_SERVER["REQUEST_METHOD"] === 'POST') {
  // Sanitize inputs
  $name = $conn->real_escape_string($_POST['name']);
  $minutes = intval($_POST['minutes']);
  $calories = intval($_POST['calories']);
  $fat = floatval($_POST['fat']);
  $protein = floatval($_POST['protein']);
  $sodium = floatval($_POST['sodium']);
  $carbohydrates = floatval($_POST['carbohydrates']);
  $description = $conn->real_escape_string($_POST['description']);
  $rating = floatval($_POST['rating']);

  $sql = "INSERT INTO recipe (name, minutes, calories, fat, protein, sodium, carbohydrates, description, rating)
          VALUES ('$name', $minutes, $calories, $fat, $protein, $sodium, $carbohydrates, '$description', $rating)";

  if ($conn->query($sql) === TRUE) {
    $message = "<div class='alert alert-success'><span>✓</span><span>Recipe added successfully!</span></div>";
  } else {
    $message = "<div class='alert alert-danger'><span>✕</span><span>Error: " . htmlspecialchars($conn->error) . "</span></div>";
  }
}

$content = 'add_recipe_content.php';
include 'layout.php';
?>