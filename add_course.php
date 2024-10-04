<?php
session_start();
include 'db.php'; // Adjust path if needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $course_name = $_POST['course_name'];
    $user_id = $_SESSION['user_id'];

    // Prepare and execute the insert statement
    $sql = "INSERT INTO courses (course_name, user_id) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $course_name, $user_id);

    if ($stmt->execute()) {
        echo "Course added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>
