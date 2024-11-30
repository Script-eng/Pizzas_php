<!-- views/pizza/create.php -->
<h1>Create a New Pizza</h1>
<form method="POST" action="index.php?route=pizza/create">
    <label for="name">Pizza Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="category">Category:</label>
    <input type="text" id="category" name="category" required><br>

    <label for="vegetarian">Vegetarian:</label>
    <input type="checkbox" id="vegetarian" name="vegetarian"><br>

    <button type="submit">Create Pizza</button>
</form>
