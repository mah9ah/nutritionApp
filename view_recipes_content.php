<?php
// view_recipes_content.php
// Query the recipe table
$sql = "SELECT id, name, minutes, calories, protein, fat, carbohydrates, rating, description
        FROM recipe
        ORDER BY updated DESC, id DESC
        LIMIT 100";
$result = $conn->query($sql);
?>

<!-- Page Header -->
<div class="page-header">
  <div class="page-header-top">
    <div>
      <h1 class="page-title">Recipe Manager</h1>
      <p class="page-subtitle">Manage your recipe collection</p>
    </div>
    <a href="add_recipe.php" class="btn btn-primary">
      <span>+</span>
      <span>Add New Recipe</span>
    </a>
  </div>
</div>

<!-- Search & Filters -->
<div class="search-filters">
  <div class="search-row">
    <input type="text" class="search-input" placeholder="🔍 Search recipes, cuisine, or dietary tags...">
    <select class="search-select">
      <option>All Cuisines</option>
      <option>American</option>
      <option>Mediterranean</option>
      <option>Asian</option>
      <option>Mexican</option>
    </select>
    <select class="search-select">
      <option>All Levels</option>
      <option>Easy</option>
      <option>Medium</option>
      <option>Advanced</option>
    </select>
  </div>
</div>

<!-- Recipe Cards Grid -->
<div class="recipe-grid">
  <?php if ($result && $result->num_rows > 0): ?>
    <?php while($r = $result->fetch_assoc()): ?>
      <div class="recipe-card">
        <div class="recipe-card-header">
          <h3 class="recipe-title"><?= htmlspecialchars($r['name']) ?></h3>
          <span class="recipe-time">
            <span>⏱️</span>
            <?= $r['minutes'] ?> min
          </span>
        </div>
        
        <div class="recipe-meta">
          <span class="recipe-meta-item">
            <span>👥</span>
            <?= rand(2, 6) ?> servings
          </span>
          <span class="recipe-meta-item">
            <span>⭐</span>
            <?= $r['rating'] ?: 'N/A' ?>/5
          </span>
        </div>
        
        <?php if ($r['description']): ?>
          <p class="recipe-description"><?= htmlspecialchars($r['description']) ?></p>
        <?php endif; ?>
        
        <div class="recipe-footer">
          <div class="recipe-badges">
            <?php if ($r['protein'] > 20): ?>
              <span class="badge badge-success">High Protein</span>
            <?php endif; ?>
            <?php if ($r['fat'] < 10): ?>
              <span class="badge badge-primary">Low Fat</span>
            <?php endif; ?>
            <?php if ($r['calories'] < 400): ?>
              <span class="badge badge-warning">Low Calorie</span>
            <?php endif; ?>
          </div>
          <a href="view_recipe_detail.php?id=<?= $r['id'] ?>" class="btn btn-outline">View Recipe</a>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <div class="card" style="grid-column: 1 / -1;">
      <div class="alert alert-info">
        <span>ℹ️</span>
        <span>No recipes found in your collection. Start by adding your first recipe!</span>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php $conn->close(); ?>