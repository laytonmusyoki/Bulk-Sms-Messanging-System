<?php
require 'db.php';
session_start();

$success = $error = "";

// Ensure user is logged in
if (!isset($_SESSION['username'])) {
    die("Access denied. Please login.");
}

$currentUsername = $_SESSION['username'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = mysqli_real_escape_string($conn, $_POST['username']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    $sql = "UPDATE users SET username = '$newUsername', phone = '$phone' WHERE username = '$currentUsername'";

    if (mysqli_query($conn, $sql)) {
        // Update session and current username
        $_SESSION['username'] = $newUsername;
        $currentUsername = $newUsername;
        $success = "Profile updated successfully!";
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Re-fetch user data after update or initially
$query = "SELECT username, phone FROM users WHERE username = '$currentUsername'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
?>

<style>
    .profile-section {
        background-color: #fff;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
        width: 100%;
        margin: 0 auto;
    }

    .profile-section h1 {
        font-size: 26px;
        margin-bottom: 10px;
        color: #333;
    }

    .profile-section p {
        margin-bottom: 20px;
        color: #666;
    }

    .profile-section label {
        display: block;
        font-weight: bold;
        margin-top: 15px;
        margin-bottom: 8px;
        color: #444;
    }

    .profile-section input[type="text"],
    .profile-section input[type="tel"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #f9f9f9;
        font-size: 15px;
    }

    .profile-section input:focus {
        border-color: #2196f3;
        outline: none;
    }

    .profile-section button {
        margin-top: 20px;
        background-color: #2196f3;
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .profile-section button:hover {
        background-color: #1976d2;
    }

    .profile-section .success-message {
        color: green;
        margin-top: 10px;
    }

    .profile-section .error-message {
        color: red;
        margin-top: 10px;
    }
</style>

<section id="profile" class="profile-section">
    <h1>Profile Settings</h1>
    <p>Manage your account settings and preferences.</p>

    <section id="profile" class="profile-section">
    <h1>Profile Settings</h1>
    <p>Manage your account settings and preferences.</p>

    <form method="POST">
        <label for="username">Username</label>
        <input type="text" name="username" readonly id="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label for="phone">Phone Number</label>
        <input type="tel" name="phone" id="phone" value="<?= htmlspecialchars($user['phone']) ?>" required>

        <button type="submit">Update Profile</button>
    </form>

    <?php if ($success): ?>
        <div class="success-message"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endif; ?>
</section>


    <?php if ($success): ?>
        <div class="success-message"><?= $success ?></div>
    <?php elseif ($error): ?>
        <div class="error-message"><?= $error ?></div>
    <?php endif; ?>
</section>
