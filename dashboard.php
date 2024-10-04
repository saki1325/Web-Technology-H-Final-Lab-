<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}
echo "User ID: " . $_SESSION['user_id']; // Add this line for debugging

// Include the database connection
include 'db.php';

// Fetch the user's courses
$user_id = $_SESSION['user_id'];
$sql = "SELECT id, course_name FROM courses WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="styles.css">
    <script src="js/drop_course.js"></script>
</head>
<body>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            background-color: #f4f4f4;
        }

        .container {
            width: 400px;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(218, 8, 8, 0.747);
            margin: auto;
            text-align: center;
        }

        .dashboard-title {
            font-size: 2rem;
            color: #333;
            margin-top: 1rem;
        }

        .btn {
            background: #7dd654;
            color: #fff;
            border: none;
            padding: 0.75rem;
            width: 100%;
            cursor: pointer;
            margin-bottom: 1rem;
        }

        .btn:hover {
            background: #13cf0d;
        }

        /* Copyright styling */
        .copyright {
            text-align: center;
            padding: 1rem;
            font-size: 0.875rem;
            background-color: #ddd;
            width: 100%;
            position: relative;
        }

        .manage-link {
            display: block;
            margin-top: 1rem;
            text-decoration: none;
            color: #007BFF;
        }

        .add-course-form {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group input {
            width: 90%;
            padding: 0.5rem;
            box-sizing: border-box;
        }
    </style>

    <div class="container">
        <h2 class="dashboard-title">Welcome to the Dashboard</h2>
        
        <!-- Display Courses -->
        <h3>Your Courses:</h3>
        <ul id="course-list">
            <?php if (count($courses) > 0): ?>
                <?php foreach ($courses as $course): ?>
                    <li>
                        <?php echo htmlspecialchars($course['course_name']); ?>
                        <button onclick="dropCourse(<?php echo $course['id']; ?>)" class="btn">Drop Course</button>
                    </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No courses found.</li>
            <?php endif; ?>
        </ul>

        <!-- Add Course Form -->
        <div class="add-course-form">
            <h3>Add a New Course:</h3>
            <form id="addCourseForm">
                <div class="form-group">
                    <input type="text" id="course_name" placeholder="Course Name" required>
                </div>
                <button type="submit" class="btn">Add Course</button>
            </form>
        </div>

        <!-- Manage Courses Button -->
        <a href="drop_course.php" class="btn">Manage Courses</a>

        <!-- Other Buttons -->
        <a href="changepassword.php" class="btn">Change Password</a>
        <a href="logout.php" class="btn">Logout</a>
    </div>

    <!-- Copyright section at the bottom -->
    <footer class="copyright">
        &copy; <?php echo date('Y'); ?> Your Company. All rights reserved.
    </footer>

    <script>
        function dropCourse(courseId) {
            if (confirm("Are you sure you want to drop this course?")) {
                fetch('course_drop.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'course_id=' + encodeURIComponent(courseId)
                })
                .then(response => response.text())
                .then(data => {
                    alert(data); // Show the response message
                    location.reload(); // Reload the page to reflect changes
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        document.getElementById('addCourseForm').addEventListener('submit', function(e) {
            e.preventDefault(); // Prevent the default form submission

            const courseName = document.getElementById('course_name').value;

            fetch('add_course.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'course_name=' + encodeURIComponent(courseName)
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Show the response message
                location.reload(); // Reload the page to reflect changes
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>

</body>
</html>
