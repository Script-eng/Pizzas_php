<?php
switch ($method) {
    case 'GET':
        if ($id) {
            // Get a specific category
            $stmt = $pdo->prepare("SELECT * FROM category WHERE cname = ?");
            $stmt->execute([$id]);
            $category = $stmt->fetch(PDO::FETCH_ASSOC);
            echo json_encode($category);
        } else {
            // Get all categories
            $stmt = $pdo->query("SELECT * FROM category");
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode($categories);
        }
        break;

    case 'POST':
        // Create a new category
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("INSERT INTO category (cname, price) VALUES (?, ?)");
        $stmt->execute([$data['cname'], $data['price']]);
        echo json_encode(["message" => "Category created"]);
        break;

    case 'PUT':
        // Update an existing category
        $data = json_decode(file_get_contents("php://input"), true);
        $stmt = $pdo->prepare("UPDATE category SET price = ? WHERE cname = ?");
        $stmt->execute([$data['price'], $id]);
        echo json_encode(["message" => "Category updated"]);
        break;

    case 'DELETE':
        // Delete a category
        $stmt = $pdo->prepare("DELETE FROM category WHERE cname = ?");
        $stmt->execute([$id]);
        echo json_encode(["message" => "Category deleted"]);
        break;

    default:
        echo json_encode(["error" => "Invalid request"]);
        break;
}
?>
