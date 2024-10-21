<?php
switch ($method) {
    case 'GET':
        if ($id) {
            // Get a specific order
            $stmt = $pdo->prepare("SELECT * FROM `order` WHERE id = ?");
            $stmt->execute([$id]);
            $order = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($order);
        } else {
            // Get all orders
            $stmt = $pdo->query("SELECT * FROM `order`");
            $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($orders);
        }
        break;

    case 'POST':
        // Create a new order
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO `order` (pizzaname, amount, taken, dispatched) VALUES (?, ?, ?, ?)");
        $stmt->execute([$data['pizzaname'], $data['amount'], $data['taken'], $data['dispatched']]);
        echo json_encode(["message" => "Order created"]);
        break;

    case 'PUT':
        // Update an existing order
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE `order` SET amount = ?, taken = ?, dispatched = ? WHERE id = ?");
        $stmt->execute([$data['amount'], $data['taken'], $data['dispatched'], $id]);
        echo json_encode(["message" => "Order updated"]);
        break;

    case 'DELETE':
        // Delete an order
        $stmt = $pdo->prepare("DELETE FROM `order` WHERE id = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Order deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
        break;
}
?>

