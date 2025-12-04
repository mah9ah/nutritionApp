<?php
// dashboard_content.php
?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Dashboard Overview</h1>
            <p class="page-subtitle">Track your recipes, ingredients, and meal planning progress</p>
        </div>
    </div>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Total Recipes</span>
            <span class="stat-icon">🍽️</span>
        </div>
        <div class="stat-value"><?= $totalRecipes ?></div>
        <div class="stat-change positive">+<?= $lastWeekRecipes ?> from last week</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Ingredients</span>
            <span class="stat-icon">🥕</span>
        </div>
        <div class="stat-value">6</div>
        <div class="stat-change">Well stocked pantry</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Planned Meals</span>
            <span class="stat-icon">📅</span>
        </div>
        <div class="stat-value">5</div>
        <div class="stat-change">This week</div>
    </div>

    <div class="stat-card">
        <div class="stat-header">
            <span class="stat-label">Weekly Goal</span>
            <span class="stat-icon">📈</span>
        </div>
        <div class="stat-value">24%</div>
        <div class="stat-progress">
            <div class="stat-progress-bar" style="width: 24%"></div>
        </div>
    </div>
</div>

<!-- Recent Recipes Section -->
<div class="dashboard-section">
    <div class="section-header">
        <div>
            <h2 class="section-title">Recent Recipes</h2>
            <p class="section-subtitle">Your latest culinary creations</p>
        </div>
        <a href="view_recipes.php" class="btn btn-outline">View All</a>
    </div>

    <div class="recent-recipes-list">
        <?php if ($recentRecipes && $recentRecipes->num_rows > 0): ?>
            <?php while($recipe = $recentRecipes->fetch_assoc()): ?>
                <div class="recent-recipe-item">
                    <div class="recipe-item-content">
                        <h3 class="recipe-item-title"><?= htmlspecialchars($recipe['name']) ?></h3>
                        <div class="recipe-item-meta">
                            <span class="meta-item">
                                <span class="meta-icon">⏱️</span>
                                <?= $recipe['minutes'] ?> min
                            </span>
                            <span class="meta-item">
                                <span class="meta-icon">👥</span>
                                <?= rand(2, 4) ?> servings
                            </span>
                            <span class="meta-item">
                                <span class="meta-icon">⭐</span>
                                <?= $recipe['rating'] ?: 'N/A' ?>/5
                            </span>
                            <span class="meta-item cuisine">
                                <span class="meta-icon">🌎</span>
                                <?php 
                                    $cuisines = ['American', 'Mediterranean', 'Asian'];
                                    echo $cuisines[array_rand($cuisines)];
                                ?>
                            </span>
                        </div>
                        <div class="recipe-item-badges">
                            <?php if (rand(0, 1)): ?>
                                <span class="badge badge-success">High Protein</span>
                            <?php endif; ?>
                            <?php if (rand(0, 1)): ?>
                                <span class="badge badge-primary">Gluten-Free</span>
                            <?php endif; ?>
                            <?php if (rand(0, 1)): ?>
                                <span class="badge badge-warning">Healthy</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="empty-state">
                <p class="text-muted">No recipes yet. Start by adding your first recipe!</p>
                <a href="add_recipe.php" class="btn btn-primary" style="margin-top: 16px;">
                    <span>+</span>
                    <span>Add Your First Recipe</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $conn->close(); ?>