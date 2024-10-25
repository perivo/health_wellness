<?php 
session_start();

if (isset($_SESSION['user_id'])) {
    header('Location: pages/home.php');
    exit;
}

// Display the landing page content
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Health & Wellness App</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container text-center mt-5">
    <h1>Welcome to Your Personal Health & Wellness Journey!</h1>
    <p class="lead">
        Discover a healthier, happier you with our comprehensive health and wellness application designed just for you. 
        Whether you're looking to improve your diet, learn yoga, or simply take charge of your health, we have the tools and resources to support you every step of the way.
    </p>
    <hr>
    <h2>Why Choose Our App?</h2>
    <p>
        - <strong>Personalized Health Tips:</strong> Receive tailored advice based on your unique profile and goals.<br>
        - <strong>Yoga and Fitness Guides:</strong> Access a variety of yoga exercises and workout plans to suit all levels.<br>
        - <strong>Diet Planning:</strong> Get customized diet plans that fit your lifestyle and preferences.<br>
        - <strong>Community Support:</strong> Join a community of like-minded individuals to share your journey and gain motivation.
    </p>
    <hr>
    <h2>Get Started Today!</h2>
    <p>
        Ready to embark on your journey to better health? 
        <a href="auth/register.php" class="btn btn-success">Sign Up</a> to create your personalized profile or 
        <a href="auth/login.php" class="btn btn-primary">Log In</a> if you're already a member.
    </p>
    <hr>
    <footer class="mt-4">
        <p>© 2024 Health & Wellness | All rights reserved</p>
    </footer>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
