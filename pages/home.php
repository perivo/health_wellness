 
<?php
include '../includes/db.php';
include '../includes/header.php';
?>

<div class="container mt-4">
    <h2>Welcome to Health & Wellness</h2>
    <p>Explore health tips, yoga exercises, and personalized diet plans.</p>
    
    <!-- Latest Articles Section -->
    <h3>Latest Articles</h3>
    <div class="row">
        <?php
        $result = $conn->query("SELECT * FROM articles ORDER BY created_at DESC LIMIT 3");
        while ($article = $result->fetch_assoc()) {
            echo "<div class='col-md-4'>";
            if ($article['image_path']) {
                echo "<img src='{$article['image_path']}' alt='Article Image' class='img-fluid mb-3'>";
            }
            echo "<h4>{$article['title']}</h4>";
            echo "<p>" . substr($article['content'], 0, 100) . "...</p>";
            echo "<a href='article.php?id={$article['id']}' class='btn btn-primary'>Read more</a>";
            echo "</div>";
        }
        ?>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
