<?php global $message; ?>
<!-- Page Header -->
<div class="page-header">
    <div class="page-header-top">
        <div>
            <h1 class="page-title">Add New Recipe</h1>
            <p class="page-subtitle">Create a custom recipe and add it to your collection</p>
        </div>
        <a href="view_recipes.php" class="btn btn-outline">
            <span>←</span>
            <span>Back to Recipes</span>
        </a>
    </div>
</div>

<!-- Display message if any -->
<?= $message ?>

<!-- Recipe Form -->
<div class="card" style="max-width: 900px;">
    <form method="post" class="form-grid">
        <!-- Basic Information -->
        <div class="form-row">
            <div class="form-group" style="grid-column: span 2;">
                <label class="form-label">Recipe Name *</label>
                <input type="text" name="name" class="form-input" placeholder="e.g., Grilled Chicken with Brown Rice" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Cooking Time (minutes)</label>
                <input type="number" name="minutes" class="form-input" placeholder="40" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Rating (0-5)</label>
                <input type="number" name="rating" class="form-input" placeholder="4.5" step="0.1" min="0" max="5">
            </div>
        </div>

        <!-- Nutritional Information -->
        <div style="margin: 20px 0 10px; padding-top: 20px; border-top: 1px solid var(--border);">
            <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 4px;">Nutritional Information</h3>
            <p class="text-muted" style="font-size: 13px;">Per serving nutritional values</p>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Calories</label>
                <input type="number" name="calories" class="form-input" placeholder="450" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Protein (g)</label>
                <input type="number" name="protein" class="form-input" placeholder="30" step="0.1" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Fat (g)</label>
                <input type="number" name="fat" class="form-input" placeholder="12" step="0.1" min="0">
            </div>
            <div class="form-group">
                <label class="form-label">Carbs (g)</label>
                <input type="number" name="carbohydrates" class="form-input" placeholder="45" step="0.1" min="0">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label class="form-label">Sodium (mg)</label>
                <input type="number" name="sodium" class="form-input" placeholder="800" step="0.1" min="0">
            </div>
        </div>

        <!-- Instructions -->
        <div style="margin-top: 20px;">
            <div class="form-group">
                <label class="form-label">Description / Instructions</label>
                <textarea name="description" class="form-textarea" placeholder="Describe your recipe and provide cooking instructions..." rows="8"></textarea>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="form-actions">
            <button type="reset" class="btn btn-secondary">Reset Form</button>
            <button type="submit" class="btn btn-success">
                <span>✓</span>
                <span>Add Recipe</span>
            </button>
        </div>
    </form>
</div>