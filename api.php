<?php
header("Content-Type: application/json");

$host = 'localhost';
$db = 'pizzeria_db';  // replace with your database name
$user = 'root';       // your database username
$pass = '';           // your database password

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



// Get all pizzas
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['table']) && $_GET['table'] == 'pizza') {
    $sql = "SELECT * FROM pizza";
    $result = $conn->query($sql);
    $pizzas = [];

    while ($row = $result->fetch_assoc()) {
        $pizzas[] = $row;
    }
    echo json_encode($pizzas);
}

// Get all categories
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['table']) && $_GET['table'] == 'category') {
    $sql = "SELECT * FROM category";
    $result = $conn->query($sql);
    $categories = [];

    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
    echo json_encode($categories);
}

// Get all orders
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['table']) && $_GET['table'] == 'order') {
    $sql = "SELECT * FROM `order`";
    $result = $conn->query($sql);
    $orders = [];

    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
    echo json_encode($orders);
}

?>


