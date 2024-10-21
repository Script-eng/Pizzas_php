<?php
class PizzaService {
    private $conn;

    public function __construct() {
        $this->conn = new mysqli('localhost', 'root', '', 'pizzeria_db');
    }

    public function getPizzas() {
        $sql = "SELECT * FROM pizza";
        $result = $this->conn->query($sql);
        $pizzas = [];
        while ($row = $result->fetch_assoc()) {
            $pizzas[] = $row;
        }
        return $pizzas;
    }

    public function getCategories() {
        $sql = "SELECT * FROM category";
        $result = $this->conn->query($sql);
        $categories = [];
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
        return $categories;
    }

    public function getOrders() {
        $sql = "SELECT * FROM `order`";
        $result = $this->conn->query($sql);
        $orders = [];
        while ($row = $result->fetch_assoc()) {
            $orders[] = $row;
        }
        return $orders;
    }
}

$server = new SoapServer(null, [
    'uri' => "http://localhost/Version1-pizzas-webSeminar/SOAP-client/server.php",
    'location' => "http://localhost/Version1-pizzas-webSeminar/SOAP-client/server.php"
]);

$server->setClass("PizzaService");
$server->handle();
