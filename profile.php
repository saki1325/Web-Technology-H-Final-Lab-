<?php
session_start();
include '../php/db.php';

<?php
session_start();
include 'db.php'; // Include the database connection script

// Your other code to interact with the database...
?>

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user data
$sql = "SELECT username, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($username, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Profile</title>
</head>
<body>
    <h1>Welcome, <?php echo $username; ?></h1>
    <p>Email: <?php echo $email; ?></p>
    
    <a href="/views/courses.php">Manage Courses</a>
    <a href="/php/logout.php">Logout</a>
</body>
</html>
