<?php
session_start();
require('db.php');

if (isset($_POST['old_password'])) {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];

    $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($old_password, $user['password'])) {
        echo "valid";
    } else {
        echo "invalid";
    }
}
?>
