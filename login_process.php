<?php
// Start a session to manage user login
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Optional: Restrict access based on role
if ($_SESSION['role'] !== 'admin') {
    die('Access denied. Admins only.');
}

// Include the database configuration file
include 'db_config.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    // Validate form data
    if (empty($username) || empty($password)) {
        die('Username and password are required.');
    }

    // Check if the user exists in the database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Store user data in the session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect to different pages based on role
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'registered_visitor') {
                header("Location: registered_dashboard.php");
            } else {
                header("Location: index.html");
            }
            exit();
        } else {
            die('Invalid password.');
        }
    } else {
        die('User not found.');
    }
}
?>
