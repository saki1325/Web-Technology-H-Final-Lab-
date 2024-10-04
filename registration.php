<?php
require('db.php');
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already exists";
    } else {
        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $username, $password);
        if ($stmt->execute()) {
            header('Location: login.php');
            exit();
        } else {
            $error = "Error registering user";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
    <script src="validate.js"></script>
    <script src="ajax.js"></script>
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            width: 300px;
            background: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(218, 8, 8, 0.747);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-group input {
            width: 90%;
            padding: 1rem;
            box-sizing: border-box;
        }
        .error {
            color: red;
            font-size: 0.875rem;
        }
        .btn {
            background: #7dd654;
            color: #fff;
            border: none;
            padding: 0.75rem;
            width: 100%;
            cursor: pointer;
        }
        .btn:hover {
            background: #13cf0d;
        }
        .switch-link {
            display: block;
            margin-top: 1rem;
            text-align: center;
        }
    </style>

    <div class="container">
        <h2>Register</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form id="registerForm" method="POST" onsubmit="return validateForm()">
            <input type="email" name="email" id="email" placeholder="Email">
            <input type="text" name="username" id="username" placeholder="Username">
            <input type="password" name="password" id="password" placeholder="Password">
            <input type="Contract number" name="contract number" id="contract number" placeholder="contractnumber">
<label for="gender">Gender</label>
                <select id="gender" name="gender">
                    <option value="">Select</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
                <div class="error" id="genderError"></div>
            <p id="emailCheck" class="error"></p>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
