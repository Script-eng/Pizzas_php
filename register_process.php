<?php
// Include the database configuration file
include 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate form data
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        die('All fields are required.');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Invalid email format.');
    }
    if ($password !== $confirmPassword) {
        die('Passwords do not match.');
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Check if the username or email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->rowCount() > 0) {
        die('Username or email already exists.');
    }

    // Insert user into the database
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$username, $email, $hashedPassword])) {
        echo 'Registration successful!';
        header("Location: login.html");
    } else {
        echo 'An error occurred. Please try again.';
    }
}
?>
