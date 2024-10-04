<?php
session_start();
include 'db.php'; // Adjust path if needed

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid request method: " . $_SERVER['REQUEST_METHOD'];
    exit;
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "User not logged in.";
    exit;
}

// Check if course_id is set in the POST request
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    // Prepare the SQL statement to drop the course
    $sql = "DELETE FROM courses WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $course_id, $user_id);

    if ($stmt->execute()) {
        echo "Course dropped successfully.";
    } else {
        echo "Error dropping course: " . $stmt->error;
    }
    $stmt->close();
} else {
    echo "Course ID not provided.";
}
?>
