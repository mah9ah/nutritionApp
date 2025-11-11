<?php
// layout.php
// expects $content to be set to a filename relative to this folder
// optional $activeNav for highlighting active menu item
if (!isset($activeNav)) $activeNav = '';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <div class="app-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <div class="sidebar-brand">
        <div class="sidebar-brand-icon">🍳</div>
        <span class="sidebar-brand-text">HoosHungry</span>
      </div>
      
      <nav>
        <ul class="sidebar-nav">
          <li class="sidebar-nav-item">
            <a href="dashboard.php" class="sidebar-nav-link <?= $activeNav === 'dashboard' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">📊</span>
              <span>Dashboard</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="view_recipes.php" class="sidebar-nav-link <?= $activeNav === 'recipes' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">📖</span>
              <span>Recipes</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="#" class="sidebar-nav-link <?= $activeNav === 'ingredients' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">🥕</span>
              <span>Ingredients</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="#" class="sidebar-nav-link <?= $activeNav === 'meal-planning' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">📅</span>
              <span>Meal Planning</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="#" class="sidebar-nav-link <?= $activeNav === 'analytics' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">📈</span>
              <span>Analytics</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="#" class="sidebar-nav-link <?= $activeNav === 'profile' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">👤</span>
              <span>Profile</span>
            </a>
          </li>
          <li class="sidebar-nav-item">
            <a href="#" class="sidebar-nav-link <?= $activeNav === 'settings' ? 'active' : '' ?>">
              <span class="sidebar-nav-icon">⚙️</span>
              <span>Settings</span>
            </a>
          </li>
        </ul>
      </nav>
      
      <div class="sidebar-footer">
        <a href="add_recipe.php" class="btn-add-recipe">
          <span>+</span>
          <span>Add Recipe</span>
        </a>
      </div>
    </aside>
    
    <!-- Main Content -->
    <main class="main-content">
      <?php include($content); ?>
    </main>
  </div>
</body>
</html>