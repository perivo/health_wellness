<?php
include '../includes/db.php'; // Database connection


// Handle message deletion
if (isset($_GET['delete'])) {
    $message_id = $_GET['delete'];
    $conn->query("DELETE FROM contact_messages WHERE id = $message_id");
    header("Location: manage_messages.php");
    exit;
}

// Fetch all messages from the database
$messages = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
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
    <!-- Back to Dashboard button -->
    <a href="dashboard.php" class="btn btn-secondary mb-4">Back to Dashboard</a>
    
    <h2>Contact Messages</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Message</th>
                <th>Date</th>
                <th>Actions</th> <!-- New column for actions -->
            </tr>
        </thead>
        <tbody>
            <?php while ($message = $messages->fetch_assoc()): ?>
                <tr>
                    <td><?= $message['id'] ?></td>
                    <td><?= htmlspecialchars($message['name']) ?></td>
                    <td><?= htmlspecialchars($message['email']) ?></td>
                    <td><?= htmlspecialchars($message['message']) ?></td>
                    <td><?= $message['created_at'] ?></td>
                    <td>
                        <!-- Delete button -->
                        <a href="manage_messages.php?delete=<?= $message['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>
