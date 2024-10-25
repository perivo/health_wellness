<?php
include '../includes/db.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle Article Creation
    if (isset($_POST['create'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image_path = '';

        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            }
        }

        $stmt = $conn->prepare("INSERT INTO articles (title, content, image_path) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $title, $content, $image_path);
        $stmt->execute();
        $stmt->close();
    }

    // Handle Article Update
    if (isset($_POST['update'])) {
        $article_id = $_POST['article_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $image_path = $_POST['existing_image'];

        // Check for new image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                $image_path = $target_file;
            }
        }

        $stmt = $conn->prepare("UPDATE articles SET title = ?, content = ?, image_path = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $content, $image_path, $article_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Handle Delete Request
if (isset($_GET['delete'])) {
    $article_id = $_GET['delete'];
    $conn->query("DELETE FROM articles WHERE id = $article_id");
    header("Location: manage_articles.php");
}

// Get Article to Edit
$edit_article = null;
if (isset($_GET['edit'])) {
    $article_id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM articles WHERE id = $article_id");
    $edit_article = $result->fetch_assoc();
}
?>
<?php
if (!isset($_SESSION)) { 
    session_start(); 
} 
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Health & Wellness</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_users.php">Manage Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_articles.php">Manage Articles</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="manage_contacts.php">Manage Contacts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-danger text-white" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<div class="container mt-4">

<div class="container mt-4">
    <h2>Manage Articles</h2>

    <!-- Add or Edit Article Form -->
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="article_id" value="<?php echo $edit_article['id'] ?? ''; ?>">
        <div class="form-group">
            <label for="title">Article Title</label>
            <input type="text" name="title" class="form-control" value="<?php echo $edit_article['title'] ?? ''; ?>" required>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" required><?php echo $edit_article['content'] ?? ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="image">Upload Image</label>
            <input type="file" name="image" class="form-control-file">
            <?php if ($edit_article && $edit_article['image_path']): ?>
                <p>Current Image: <img src="<?php echo $edit_article['image_path']; ?>" alt="Article Image" width="50"></p>
                <input type="hidden" name="existing_image" value="<?php echo $edit_article['image_path']; ?>">
            <?php endif; ?>
        </div>
        <?php if ($edit_article): ?>
            <button type="submit" name="update" class="btn btn-warning">Update Article</button>
        <?php else: ?>
            <button type="submit" name="create" class="btn btn-primary">Add Article</button>
        <?php endif; ?>
    </form>

    <!-- Back to Admin Dashboard Button -->
    <a href="../admin/dashboard.php" class="btn btn-secondary mt-4">Back to Admin Dashboard</a>

    <!-- Articles List -->
    <h3 class="mt-4">All Articles</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $result = $conn->query("SELECT * FROM articles");
            while ($article = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$article['id']}</td>";
                echo "<td>{$article['title']}</td>";
                echo "<td>";
                if ($article['image_path']) {
                    echo "<img src='{$article['image_path']}' alt='Article Image' width='50'>";
                } else {
                    echo "No Image";
                }
                echo "</td>";
                echo "<td>
                    <a href='manage_articles.php?edit={$article['id']}' class='btn btn-info'>Edit</a>
                    <a href='manage_articles.php?delete={$article['id']}' class='btn btn-danger'>Delete</a>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
