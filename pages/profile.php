<?php
include '../includes/db.php';
include '../includes/header.php';

if(!isset($_SESSION)) 
{ 
    session_start(); 
} 
$user_id = $_SESSION['user_id'] ?? null; // Check if user ID is set in session

if (!$user_id) {
    echo "You need to log in to access this page.";
    exit;
}

// Fetch user information
$user = $conn->query("SELECT * FROM users WHERE id = $user_id")->fetch_assoc();

if (!$user) {
    echo "User not found.";
    exit;
}

$username = $user['username'] ?? '';
$email = $user['email'] ?? '';
$bio = $user['bio'] ?? '';
$height = $user['height'] ?? '';
$weight = $user['weight'] ?? '';
$birthdate = $user['birthdate'] ?? '';
$profile_picture = $user['profile_picture'] ?? '';
$password = '';
$confirm_password = '';
$bmi = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $bio = $conn->real_escape_string($_POST['bio']);
    $height = $conn->real_escape_string($_POST['height']);
    $weight = $conn->real_escape_string($_POST['weight']);
    $birthdate = $conn->real_escape_string($_POST['birthdate']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
        $target_dir = "../uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file);
        $profile_picture = $target_file;
    }

    if ($height > 0 && $weight > 0) {
        $height_in_meters = $height / 100;
        $bmi = $weight / ($height_in_meters * $height_in_meters);
    }

    if (!empty($password) && $password === $confirm_password) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, bio = ?, height = ?, weight = ?, birthdate = ?, profile_picture = ?, password = ? WHERE id = ?");
        $stmt->bind_param("sssddsssi", $username, $email, $bio, $height, $weight, $birthdate, $profile_picture, $hashed_password, $user_id);
    } else {
        $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, bio = ?, height = ?, weight = ?, birthdate = ?, profile_picture = ? WHERE id = ?");
        $stmt->bind_param("sssddssi", $username, $email, $bio, $height, $weight, $birthdate, $profile_picture, $user_id);
    }
    $stmt->execute();
    $stmt->close();
}
?>

<div class="container mt-4">
    <h2>Your Profile</h2>

    <!-- Display Profile Picture in Circle -->
    <?php if ($profile_picture): ?>
        <div class="text-center mb-4">
            <img src="<?= $profile_picture ?>" alt="Profile Picture" class="rounded-circle" width="150" height="150" style="object-fit: cover;">
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($username) ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($email) ?>" required>
        </div>
        <div class="form-group">
            <label for="bio">Bio</label>
            <textarea name="bio" class="form-control"><?= htmlspecialchars($bio) ?></textarea>
        </div>
        <div class="form-group">
            <label for="birthdate">Birthdate</label>
            <input type="date" name="birthdate" class="form-control" value="<?= $birthdate ?>">
        </div>
        <div class="form-group">
            <label for="height">Height (cm)</label>
            <input type="number" name="height" class="form-control" step="0.1" value="<?= $height ?>" required>
        </div>
        <div class="form-group">
            <label for="weight">Weight (kg)</label>
            <input type="number" name="weight" class="form-control" step="0.1" value="<?= $weight ?>" required>
        </div>
        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control-file">
        </div>
        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Update Profile</button>
    </form>

    <?php if ($bmi): ?>
        <div class="mt-4">
            <h4>Your BMI: <?= round($bmi, 2) ?></h4>
            <?php
                if ($bmi < 18.5) {
                    echo "<p>Underweight</p>";
                } elseif ($bmi >= 18.5 && $bmi < 24.9) {
                    echo "<p>Normal weight</p>";
                } elseif ($bmi >= 25 && $bmi < 29.9) {
                    echo "<p>Overweight</p>";
                } else {
                    echo "<p>Obese</p>";
                }
            ?>
        </div>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
