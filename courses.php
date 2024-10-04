<?php
session_start();
include 'db.php'; // Include the database connection script

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch enrolled courses
$sql = "SELECT id, course_name FROM courses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($course_id, $course_name);

$courses = [];
while ($stmt->fetch()) {
    $courses[] = ['id' => $course_id, 'name' => $course_name];
}
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/drop_course.js"></script>
    <link rel="stylesheet" href="../css/style.css">
    <title>Your Courses</title>
</head>
<body>
    <h1>Your Courses</h1>
    <ul id="course-list">
        <?php if (count($courses) > 0): ?>
            <?php foreach ($courses as $course): ?>
                <li>
                    <?php echo htmlspecialchars($course['name']); ?>
                    <button onclick="dropCourse(<?php echo $course['id']; ?>)">Drop Course</button>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No courses found.</li>
        <?php endif; ?>
    </ul>
</body>
</html>

