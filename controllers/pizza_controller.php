<?php
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
}
?>
