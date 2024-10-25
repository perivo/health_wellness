<?php
include '../includes/db.php';
include '../includes/header.php';

$article_id = $_GET['id'];

// Ensure the article ID is a number to avoid SQL injection
$article_id = intval($article_id);

// Fetch the article from the database
$article = $conn->query("SELECT * FROM articles WHERE id = $article_id")->fetch_assoc();

// If the article doesn't exist, show an error
if (!$article) {
    echo "<div class='container mt-4'><p class='alert alert-danger'>Article not found.</p></div>";
    include '../includes/footer.php';
    exit;
}
?>

<div class="container mt-4">
    <h2><?= htmlspecialchars($article['title']) ?></h2>

    <?php if (!empty($article['image_path'])): ?>
        <img src="<?= htmlspecialchars($article['image_path']) ?>" alt="Article Image" class="img-fluid mb-3">
    <?php endif; ?>

    <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
</div>

<?php include '../includes/footer.php'; ?>
