<?php
session_start();
require('db.php');
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: dashboard.php');
            exit();
        } else {
            $error = "Invalid password";
        }
    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
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
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form method="POST">
            <input type="email" name="email" placeholder="Email">
            <input type="password" name="password" placeholder="Password">
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
