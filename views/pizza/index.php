<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pizzas</title>
</head>
<body>
    <h1>Pizza List</h1>
    <a href="index.php?route=pizza&action=create">Add New Pizza</a>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Category</th>
                <th>Vegetarian</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pizzas as $pizza): ?>
                <tr>
                    <td><?= $pizza['vegetarian'] ?></td>
                    <td><?= $pizza['categoryname'] ?></td>
                    <td><?= $pizza['vegetarian'] ?></td>
                    <td>
                        <a href="index.php?route=pizza&action=edit&id=<?= $pizza['vegetarian'] ?>">Edit</a>
                        <a href="index.php?route=pizza&action=delete&id=<?= $pizza['vegetarian'] ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
