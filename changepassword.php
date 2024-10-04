<?php
session_start();
require('db.php');
$error = '';
$success = '';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
    $user_id = $_SESSION['user_id'];

    // Update password
    $stmt = $conn->prepare("UPDATE users SET password=? WHERE id=?");
    $stmt->bind_param("si", $new_password, $user_id);
    if ($stmt->execute()) {
        $success = "Password updated successfully";
    } else {
        $error = "Error updating password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="styles.css">
    <script src="ajax.js"></script>
</head>
<body>
    <div class="container">
        <h2>Change Password</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <?php if ($success): ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>
        <form id="changePasswordForm" method="POST">
            <input type="password" name="old_password" id="old_password" placeholder="Old Password">
            <input type="password" name="new_password" id="new_password" placeholder="New Password">
            <p id="passwordCheck" class="error"></p>
            <button type="submit">Change Password</button>
        </form>
    </div>
</body>
</html>
