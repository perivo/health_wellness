<?php 
include '../includes/db.php';
include '../includes/header.php';

$api_key = 'mehNU2/KV0VhoXfXrb7Xaw==uxdUBQbd5OFTBpiv'; // Replace with your actual API key
$query = isset($_GET['query']) ? urlencode($_GET['query']) : 'brisket'; // Default query
$api_url = "https://api.api-ninjas.com/v1/recipe?query=$query";

$options = [
    "http" => [
        "header" => "X-Api-Key: $api_key"
    ]
];

$context = stream_context_create($options);
$max_retries = 3; // Set the number of retries
$retry_delay = 2; // Delay in seconds between retries
$response = false;

for ($attempt = 0; $attempt < $max_retries; $attempt++) {
    $response = @file_get_contents($api_url, false, $context); // Suppress warnings for cleaner error handling
    
    if ($response !== false) {
        break; // Exit loop if request was successful
    }
    
    sleep($retry_delay); // Wait before retrying
}

if ($response === false) {
    echo "<p>Error: Unable to retrieve recipe information at this time. Please try again later.</p>";
    $recipe_data = [];
} else {
    $recipe_data = json_decode($response, true);

    // Debugging: Check the structure of the API response

}

?>

<div class="container mt-4">
    <h2>Recipe Information</h2>
    <form method="get" class="mb-3">
        <label for="query">Search for Recipe:</label>
        <input type="text" name="query" id="query" placeholder="Enter food item" class="form-control" value="<?= htmlspecialchars($query) ?>" required>
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>

    <?php if (!empty($recipe_data)): ?>
        <h3>Results for: <?= htmlspecialchars($query) ?></h3>
        <ul>
            <?php 
            $count = 0; // Initialize a counter to limit the number of recipes displayed
            foreach ($recipe_data as $item):
                if ($count >= 6) break; // Limit to 6 recipes

                // Adjust this line based on the actual API response structure
                $title = isset($item['title']) ? htmlspecialchars($item['title']) : 'Unknown Recipe';

                // Check if 'ingredients' exists and is an array, otherwise handle it appropriately
                if (isset($item['ingredients'])) {
                    $ingredients = is_array($item['ingredients']) ? $item['ingredients'] : explode('|', $item['ingredients']);
                    $ingredients_list = implode(', ', array_map('htmlspecialchars', $ingredients)); // Escape ingredients
                } else {
                    $ingredients_list = 'No ingredients available';
                }

                $instructions = isset($item['instructions']) ? htmlspecialchars($item['instructions']) : 'No instructions available';
                $servings = isset($item['servings']) ? htmlspecialchars($item['servings']) : 'Not specified';
            ?>
                <li>
                    <strong>Recipe Name:</strong> <?= $title ?><br>
                    <strong>Servings:</strong> <?= $servings ?><br>
                    <strong>Ingredients:</strong> <?= $ingredients_list ?><br>
                    <strong>Instructions:</strong> <?= $instructions ?><br>
                </li>
                <hr>
            <?php 
                $count++; // Increment the counter
            endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No recipe information available for your query.</p>
    <?php endif; ?>
</div>

<!-- Footer -->
<footer class="bg-light text-center text-lg-start mt-5">
    <div class="text-center p-3">
        &copy; 2024 Health & Wellness | All rights reserved
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="../assets/js/main.js"></script>
</body>
</html>

<?php include '../includes/footer.php'; ?>
