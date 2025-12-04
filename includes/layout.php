<?php
require_once __DIR__ . '/session.php';
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle ?? 'HOOSHungry'; ?></title>
    <link rel="stylesheet" href="../assets/styles.css">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h1>Recipe Manager</h1>
                <p>Meal Planning Dashboard</p>
            </div>
            
            <nav class="sidebar-nav">
                <a href="dashboard.php" class="nav-item <?php echo ($currentPage === 'dashboard') ? 'active' : ''; ?>">
                    <span class="icon">🏠</span>
                    <span>Dashboard</span>
                </a>
                <a href="recipes.php" class="nav-item <?php echo ($currentPage === 'recipes') ? 'active' : ''; ?>">
                    <span class="icon">🍳</span>
                    <span>Recipes</span>
                </a>
                <a href="ingredients.php" class="nav-item <?php echo ($currentPage === 'ingredients') ? 'active' : ''; ?>">
                    <span class="icon">🥕</span>
                    <span>Ingredients</span>
                </a>
                <a href="meal_planning.php" class="nav-item <?php echo ($currentPage === 'meal_planning') ? 'active' : ''; ?>">
                    <span class="icon">📅</span>
                    <span>Meal Planning</span>
                </a>
                <a href="analytics.php" class="nav-item <?php echo ($currentPage === 'analytics') ? 'active' : ''; ?>">
                    <span class="icon">📊</span>
                    <span>Analytics</span>
                </a>
                <a href="profile.php" class="nav-item <?php echo ($currentPage === 'profile') ? 'active' : ''; ?>">
                    <span class="icon">👤</span>
                    <span>Profile</span>
                </a>
                <a href="settings.php" class="nav-item <?php echo ($currentPage === 'settings') ? 'active' : ''; ?>">
                    <span class="icon">⚙️</span>
                    <span>Settings</span>
                </a>
            </nav>
            
            <div class="sidebar-footer">
                <button class="btn-primary add-recipe-btn" onclick="window.location.href='add_recipe.php'">
                    + Add Recipe
                </button>
                <div class="user-info">
                    <p>Welcome back,</p>
                    <p><strong><?php echo htmlspecialchars(getUsername()); ?></strong></p>
                </div>
            </div>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">

            <!-- LOGOUT BUTTON (added here) -->
            <div style="position: absolute; top: 20px; right: 20px; z-index: 999;">
                <a href="logout.php" 
                   style="
                       padding: 8px 14px;
                       background: #d9534f;
                       color: white;
                       text-decoration: none;
                       border-radius: 6px;
                       font-size: 14px;
                       font-weight: bold;
                   ">
                    Logout
                </a>
            </div>
            <!-- END LOGOUT BUTTON -->

            <?php echo $content; ?>
        </main>
    </div>
</body>
</html>
