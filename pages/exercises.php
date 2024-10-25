<?php
include '../includes/db.php';
include '../includes/header.php';

$api_key = 'mehNU2/KV0VhoXfXrb7Xaw==uxdUBQbd5OFTBpiv'; // Replace with your actual API key
$default_type = 'stretching'; // Default type to fetch if none specified

// Fetching stretching exercises (similar to yoga) from the API
$exercise_type = isset($_GET['type']) ? urlencode($_GET['type']) : $default_type;
$api_url = "https://api.api-ninjas.com/v1/exercises?type=$exercise_type";

$options = [
    "http" => [
        "header" => "X-Api-Key: $api_key"
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($api_url, false, $context);

// Check if API response is valid
if ($response === false) {
    echo "<p>Error: Unable to retrieve exercises at this time. Please try again later.</p>";
    $exercises = [];
} else {
    $exercises = json_decode($response, true);
}

?>

<div class="container mt-4">
    <h2>Exercises for you</h2>
    <form method="get" class="mb-3">
        <label for="type">Search for Exercise Type:</label>
        <input type="text" name="type" id="type" placeholder="Enter type (e.g., 'stretching')" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-2">Search</button>
    </form>
    <div class="row">
        <?php
        if (!empty($exercises)) {
            foreach ($exercises as $exercise) {
                echo "<div class='col-md-4 mb-4'>";
                echo "<h4>" . htmlspecialchars($exercise['name']) . "</h4>";
                echo "<p><strong>Type:</strong> " . htmlspecialchars($exercise['type']) . "</p>";
                echo "<p><strong>Muscle Group:</strong> " . htmlspecialchars($exercise['muscle']) . "</p>";
                echo "<p><strong>Equipment:</strong> " . htmlspecialchars($exercise['equipment']) . "</p>";
                echo "<p><strong>Instructions:</strong> " . htmlspecialchars($exercise['instructions']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>No exercises found. Try searching for a different type.</p>";
        }
        ?>
    </div>
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
