<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';
requireLogin();

$user_id = getUserId();

$stats = [];

/* -------------------------------------------------
   TOTAL RECIPES (recipe table, filter by creator)
   BUT your recipe table has NO created_by column.
   So we must pull recipes created by the user from:
   created_recipes table (user_id, recipe_id)
--------------------------------------------------- */

$result = $conn->query("
    SELECT COUNT(*) AS count
    FROM created_recipes
    WHERE user_id = $user_id
");
$stats['total_recipes'] = $result->fetch_assoc()['count'];

/* -------------------------------------------------
   RECIPES ADDED IN LAST 7 DAYS
   (check recipe.submitted timestamp)
--------------------------------------------------- */
$result = $conn->query("
    SELECT COUNT(*) AS count
    FROM created_recipes cr
    JOIN recipe r ON cr.recipe_id = r.id
    WHERE cr.user_id = $user_id
    AND r.submitted >= DATE_SUB(NOW(), INTERVAL 7 DAY)
");
$stats['recipes_change'] = $result->fetch_assoc()['count'];

/* -------------------------------------------------
   TOTAL INGREDIENTS — ingredient table
--------------------------------------------------- */
$result = $conn->query("SELECT COUNT(*) AS count FROM ingredient");
$stats['total_ingredients'] = $result->fetch_assoc()['count'];

/* -------------------------------------------------
   PLANNED MEALS — join meal_plan_event → meal
   because user_id exists only in meal
--------------------------------------------------- */
$result = $conn->query("
    SELECT COUNT(*) AS count
    FROM meal_plan_event mpe
    JOIN meal m ON mpe.meal_id = m.id
    WHERE m.user_id = $user_id
    AND mpe.scheduled_at >= CURDATE()
    AND mpe.scheduled_at < DATE_ADD(CURDATE(), INTERVAL 7 DAY)
");
$stats['planned_meals'] = $result->fetch_assoc()['count'];

$weekly_goal_percent = round(($stats['planned_meals'] / 21) * 100);

/* -------------------------------------------------
   RECENT RECIPES
   Only columns that exist:
   - id
   - name
   - minutes
   - calories
   - description
   - rating
   - submitted
--------------------------------------------------- */

$recent_recipes = $conn->query("
    SELECT r.id, r.name, r.minutes, r.calories, r.description, r.rating, r.submitted
    FROM created_recipes cr
    JOIN recipe r ON cr.recipe_id = r.id
    WHERE cr.user_id = $user_id
    ORDER BY r.submitted DESC
    LIMIT 3
");

$pageTitle = 'Dashboard - HOOSHungry';
$currentPage = 'dashboard';

ob_start();
?>

<div class="page-header">
    <h1>Dashboard Overview</h1>
    <p>Track your recipes, ingredients, and meal planning progress</p>
</div>

<div class="metrics-grid">
    <div class="metric-card">
        <div class="metric-header">
            <h3>Total Recipes</h3>
            <span class="metric-icon">🍳</span>
        </div>
        <div class="metric-value"><?php echo $stats['total_recipes']; ?></div>
        <div class="metric-label">+<?php echo $stats['recipes_change']; ?> from last week</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-header">
            <h3>Ingredients</h3>
            <span class="metric-icon">🥕</span>
        </div>
        <div class="metric-value"><?php echo $stats['total_ingredients']; ?></div>
        <div class="metric-label">Total</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-header">
            <h3>Planned Meals</h3>
            <span class="metric-icon">📅</span>
        </div>
        <div class="metric-value"><?php echo $stats['planned_meals']; ?></div>
        <div class="metric-label">This week</div>
    </div>
    
    <div class="metric-card">
        <div class="metric-header">
            <h3>Weekly Goal</h3>
            <span class="metric-icon">📈</span>
        </div>
        <div class="metric-value"><?php echo $weekly_goal_percent; ?>%</div>
        <div class="metric-progress">
            <div class="metric-progress-bar" style="width: <?php echo $weekly_goal_percent; ?>%"></div>
        </div>
    </div>
</div>

<div class="section-header">
    <h2>Recent Recipes</h2>
    <p>Your latest creations</p>
</div>

<div class="recipes-grid">
    <?php if ($recent_recipes->num_rows > 0): ?>
        <?php while ($recipe = $recent_recipes->fetch_assoc()): ?>
            <div class="recipe-card">
                <h3><?php echo htmlspecialchars($recipe['name']); ?></h3>
                <div class="recipe-meta">
                    <span>⏱️ <?php echo $recipe['minutes']; ?> min</span>
                    <span>🔥 <?php echo $recipe['calories']; ?> calories</span>
                </div>

                <div class="recipe-description">
                    <?php echo htmlspecialchars(substr($recipe['description'], 0, 80)) . '...'; ?>
                </div>

                <div class="recipe-actions">
                    <button class="btn-small btn-view" onclick="window.location.href='view_recipe.php?id=<?php echo $recipe['id']; ?>'">View</button>
                    <button class="btn-icon" onclick="window.location.href='edit_recipe.php?id=<?php echo $recipe['id']; ?>'">✏️</button>
                    <button class="btn-icon" onclick="if(confirm('Delete this recipe?')) window.location.href='delete_recipe.php?id=<?php echo $recipe['id']; ?>'">🗑️</button>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="recipe-card">
            <h3>No recipes yet</h3>
            <p>Start by adding your first recipe!</p>
            <div class="recipe-actions">
                <button class="btn-small btn-view" onclick="window.location.href='add_recipe.php'">Add Recipe</button>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
include '../includes/layout.php';
?>
