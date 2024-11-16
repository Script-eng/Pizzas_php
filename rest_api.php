<?php
header("Content-Type: application/json");

class PizzaService {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'pizzeria_db');
        if ($this->conn->connect_error) {
            http_response_code(500);
            die(json_encode(["error" => "Database connection failed"]));
        }
    }

    public function getPizzas() {
        $sql = "SELECT * FROM pizza";
        $result = $this->conn->query($sql);
        return $this->fetchResults($result);
    }

    public function getCategories() {
        $sql = "SELECT * FROM category";
        $result = $this->conn->query($sql);
        return $this->fetchResults($result);
    }

    public function getOrders() {
        $sql = "SELECT * FROM `order`";
        $result = $this->conn->query($sql);
        return $this->fetchResults($result);
    }

    public function getPizzaById($id) {
        $sql = "SELECT * FROM pizza WHERE id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $this->fetchResults($result);
    }

    private function fetchResults($result) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        return $data;
    }
}

$service = new PizzaService();

// Parse the request
$requestMethod = $_SERVER['REQUEST_METHOD'];
$path = isset($_GET['path']) ? explode("/", $_GET['path']) : [];
$response = ["error" => "Invalid request"];

if (count($path) > 0) {
    switch ($path[0]) {
        case "pizzas":
            if ($requestMethod === "GET") {
                if (isset($path[1])) {
                    $response = $service->getPizzaById($path[1]);
                } else {
                    $response = $service->getPizzas();
                }
            }
            break;

        case "categories":
            if ($requestMethod === "GET") {
                $response = $service->getCategories();
            }
            break;

        case "orders":
            if ($requestMethod === "GET") {
                $response = $service->getOrders();
            }
            break;

        default:
            $response = ["error" => "Endpoint not found"];
    }
}

echo json_encode($response);
?>
