<?php
include '../includes/db.php';
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
    <h2>Admin Dashboard</h2>
    <div class="row">
        <!-- Users Count -->
        <div class="col-md-3">
            <?php
            $user_count = $conn->query("SELECT COUNT(*) AS total FROM users")->fetch_assoc()['total'];
            ?>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text"><?= $user_count ?></p>
                    <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                </div>
            </div>
        </div>

        <!-- Articles Count -->
        <div class="col-md-3">
            <?php
            $article_count = $conn->query("SELECT COUNT(*) AS total FROM articles")->fetch_assoc()['total'];
            ?>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Articles</h5>
                    <p class="card-text"><?= $article_count ?></p>
                    <a href="manage_articles.php" class="btn btn-primary">Manage Articles</a>
                </div>
            </div>
        </div>

        <!-- Contact Messages Count -->
        <div class="col-md-3">
            <?php
            $contact_count = $conn->query("SELECT COUNT(*) AS total FROM contact_messages")->fetch_assoc()['total'];
            ?>
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Contact Messages</h5>
                    <p class="card-text"><?= $contact_count ?></p>
                    <a href="manage_contacts.php" class="btn btn-primary">Manage Contacts</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>
