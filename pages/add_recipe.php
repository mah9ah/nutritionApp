<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';
requireLogin();

$user_id = getUserId();
$message = "";

// -----------------------------------------------------
// FORM SUBMISSION HANDLING
// -----------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // MAIN RECIPE FIELDS
    $name = $_POST['name'];
    $minutes = $_POST['minutes'];
    $calories = $_POST['calories'];
    $fat = $_POST['fat'];
    $protein = $_POST['protein'];
    $sodium = $_POST['sodium'];
    $saturated_fat = $_POST['saturated_fat'];
    $sugar = $_POST['sugar'];
    $carbohydrates = $_POST['carbohydrates'];
    $description = $_POST['description'];
    $rating = $_POST['rating'];

    // Insert main recipe
    $stmt = $conn->prepare("
        INSERT INTO recipe 
        (name, minutes, calories, fat, protein, sodium, saturated_fat, sugar, carbohydrates, description, rating)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("siiddddddds", 
        $name, $minutes, $calories, 
        $fat, $protein, $sodium, $saturated_fat, $sugar, $carbohydrates,
        $description, $rating
    );

    $stmt->execute();
    $recipe_id = $conn->insert_id;

    // -----------------------------------------------------
    // INSERT STEPS
    // -----------------------------------------------------
    if (!empty($_POST['steps'])) {
        $stepNumber = 1;
        foreach ($_POST['steps'] as $stepDesc) {
            if (trim($stepDesc) === "") continue;

            $stmt = $conn->prepare("
                INSERT INTO recipe_steps (recipe_id, step_number, description)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iis", $recipe_id, $stepNumber, $stepDesc);
            $stmt->execute();

            $stepNumber++;
        }
    }

    // -----------------------------------------------------
    // INSERT INGREDIENTS
    // -----------------------------------------------------
    if (!empty($_POST['ingredient_name'])) {
        for ($i = 0; $i < count($_POST['ingredient_name']); $i++) {

            $ingName = trim($_POST['ingredient_name'][$i]);
            $qty = $_POST['quantity'][$i];
            $unit = $_POST['unit_label'][$i];

            if ($ingName === "") continue;

            // Check if ingredient exists
            $stmt = $conn->prepare("SELECT id FROM ingredient WHERE name = ?");
            $stmt->bind_param("s", $ingName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $ingredient_id = $row['id'];
            } else {
                // Insert new ingredient
                $stmt = $conn->prepare("INSERT INTO ingredient (name) VALUES (?)");
                $stmt->bind_param("s", $ingName);
                $stmt->execute();
                $ingredient_id = $conn->insert_id;
            }

            // Insert into recipe_ingredients
            $stmt = $conn->prepare("
                INSERT INTO recipe_ingredients (recipe_id, ingredient_id, unit_label, quantity)
                VALUES (?, ?, ?, ?)
            ");
            $stmt->bind_param("iisd", $recipe_id, $ingredient_id, $unit, $qty);
            $stmt->execute();
        }
    }

    // -----------------------------------------------------
    // INSERT TAGS
    // -----------------------------------------------------
    if (!empty($_POST['tags'])) {
        foreach ($_POST['tags'] as $tagName) {

            $tagName = trim($tagName);
            if ($tagName === "") continue;

            // Check if tag exists
            $stmt = $conn->prepare("SELECT id FROM tag WHERE name = ?");
            $stmt->bind_param("s", $tagName);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tag_id = $row['id'];
            } else {
                // Insert new tag
                $stmt = $conn->prepare("INSERT INTO tag (name) VALUES (?)");
                $stmt->bind_param("s", $tagName);
                $stmt->execute();
                $tag_id = $conn->insert_id;
            }

            // Link recipe to tag
            $stmt = $conn->prepare("
                INSERT INTO recipe_tags (recipe_id, tag_id)
                VALUES (?, ?)
            ");
            $stmt->bind_param("ii", $recipe_id, $tag_id);
            $stmt->execute();
        }
    }

    // -----------------------------------------------------
    // LINK USER → CREATED_RECIPES
    // -----------------------------------------------------
    $stmt = $conn->prepare("
        INSERT INTO created_recipes (user_id, recipe_id)
        VALUES (?, ?)
    ");
    $stmt->bind_param("ii", $user_id, $recipe_id);
    $stmt->execute();

    $message = "✅ Recipe added successfully!";
}



// -----------------------------------------------------
// PAGE CONTENT
// -----------------------------------------------------
$pageTitle = "Add Recipe";
$currentPage = "add_recipe";

ob_start();
?>

<div class="page-header">
    <h1>Add a New Recipe</h1>
    <p>Create your own custom recipe with ingredients and steps</p>
</div>

<?php if ($message): ?>
    <div class="success-message"><?php echo $message; ?></div>
<?php endif; ?>

<form method="POST" class="recipe-form">

    <div class="form-section">
        <h2>Recipe Details</h2>
        <label>Name</label>
        <input type="text" name="name" required>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Minutes</label>
        <input type="number" name="minutes" min="1">

        <label>Rating (0–5)</label>
        <input type="number" name="rating" min="0" max="5" step="0.1">
    </div>

    <div class="form-section">
        <h2>Nutritional Info</h2>
        <div class="nutri-grid">
            <div><label>Calories</label><input type="number" name="calories"></div>
            <div><label>Fat</label><input type="number" step="0.01" name="fat"></div>
            <div><label>Protein</label><input type="number" step="0.01" name="protein"></div>
            <div><label>Sodium</label><input type="number" step="0.01" name="sodium"></div>
            <div><label>Saturated Fat</label><input type="number" step="0.01" name="saturated_fat"></div>
            <div><label>Sugar</label><input type="number" step="0.01" name="sugar"></div>
            <div><label>Carbs</label><input type="number" step="0.01" name="carbohydrates"></div>
        </div>
    </div>

    <div class="form-section">
        <h2>Ingredients</h2>

        <div id="ingredients-box"></div>

        <button type="button" onclick="addIngredient()">+ Add Ingredient</button>
    </div>

    <div class="form-section">
        <h2>Steps</h2>

        <div id="steps-box"></div>

        <button type="button" onclick="addStep()">+ Add Step</button>
    </div>

    <div class="form-section">
        <h2>Tags</h2>

        <div id="tags-box"></div>

        <button type="button" onclick="addTag()">+ Add Tag</button>
    </div>

    <button type="submit" class="btn-submit">Save Recipe</button>
</form>


<script>
function addIngredient() {
    document.getElementById("ingredients-box").insertAdjacentHTML("beforeend", `
        <div class="ingredient-row">
            <input type="text" name="ingredient_name[]" placeholder="Ingredient name">
            <input type="number" step="0.01" name="quantity[]" placeholder="Qty">
            <input type="text" name="unit_label[]" placeholder="Unit (g, cup...)">
        </div>
    `);
}

function addStep() {
    document.getElementById("steps-box").insertAdjacentHTML("beforeend", `
        <div class="step-row">
            <textarea name="steps[]" placeholder="Describe the step..."></textarea>
        </div>
    `);
}

function addTag() {
    document.getElementById("tags-box").insertAdjacentHTML("beforeend", `
        <input type="text" name="tags[]" placeholder="Tag (e.g., high protein)">
    `);
}
</script>


<?php
$content = ob_get_clean();
include '../includes/layout.php';
?>
