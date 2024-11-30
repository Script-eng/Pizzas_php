<!-- 
switch ($method) {
    case 'GET':
        if ($id) {
            // Get a specific pizza
            $stmt = $pdo->prepare("SELECT * FROM pizza WHERE pname = ?");
            $stmt->execute([$id]);
            $pizza = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($pizza);
        } else {
            // Get all pizzas
            $stmt = $pdo->query("SELECT * FROM pizza");
            $pizzas = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($pizzas);
        }
        break;

    case 'POST':
        // Create a new pizza
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO pizza (pname, categoryname, vegetarian) VALUES (?, ?, ?)");
        $stmt->execute([$data['pname'], $data['categoryname'], $data['vegetarian']]);
        echo json_encode(["message" => "Pizza created"]);
        break;

    case 'PUT':
        // Update an existing pizza
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE pizza SET categoryname = ?, vegetarian = ? WHERE pname = ?");
        $stmt->execute([$data['categoryname'], $data['vegetarian'], $id]);
        echo json_encode(["message" => "Pizza updated"]);
        break;

    case 'DELETE':
        // Delete a pizza
        $stmt = $pdo->prepare("DELETE FROM pizza WHERE pname = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Pizza deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
        break;
} -->

<?php

require_once 'db_config.php';

class PizzaController {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function index() {
        $pizzas = $this->db->query("SELECT * FROM pizza");
        include 'views/pizza/index.php';
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $category = $_POST['category'];
            $vegetarian = $_POST['vegetarian'];

            $this->db->query("INSERT INTO pizza (vegetarian pname, categoryname, vegetarian) VALUES (?, ?, ?)", [
                $name, $category, $vegetarian
            ]);

            header("Location: index.php?route=pizza");
        } else {
            include 'views/pizza/create.php';
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $category = $_POST['category'];
            $vegetarian = $_POST['vegetarian'];

            $this->db->query("UPDATE pizza SET `vegetarian pname` = ?, categoryname = ?, vegetarian = ? WHERE `vegetarian pname` = ?", [
                $name, $category, $vegetarian, $id
            ]);

            header("Location: index.php?route=pizza");
        } else {
            $pizza = $this->db->query("SELECT * FROM pizza WHERE `vegetarian pname` = ?", [$id])->fetch();
            include 'views/pizza/edit.php';
        }
    }

    public function delete($id) {
        $this->db->query("DELETE FROM pizza WHERE `vegetarian pname` = ?", [$id]);
        header("Location: index.php?route=pizza");
    }
}

$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$id = isset($_GET['id']) ? $_GET['id'] : null;

$controller = new PizzaController();

if (method_exists($controller, $action)) {
    $controller->$action($id);
} else {
    echo "404 Not Found";
}
?>
