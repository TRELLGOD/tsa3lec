<?php
session_start();

// Initialize the todos array if it doesn't exist
if (!isset($_SESSION['todos'])) {
    $_SESSION['todos'] = array();
}

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_todo'])) {
        // Add a new todo item
        $todo = trim($_POST['todo']);
        if (!empty($todo)) {
            $_SESSION['todos'][] = $todo;
        }
    } elseif (isset($_POST['update_todo'])) {
        // Update an existing todo item
        $index = $_POST['index'];
        $todo = trim($_POST['todo']);
        if (!empty($todo)) {
            $_SESSION['todos'][$index] = $todo;
        }
    } elseif (isset($_POST['delete_todo'])) {
        // Delete a todo item
        $index = $_POST['index'];
        unset($_SESSION['todos'][$index]);
        $_SESSION['todos'] = array_values($_SESSION['todos']);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>To-do App</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>To-do App</h1>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="text" name="todo" placeholder="Enter a new task">
            <button type="submit" name="add_todo">Add</button>
        </form>
        <ul>
            <?php foreach ($_SESSION['todos'] as $index => $todo) : ?>
                <li>
                    <span><?php echo $todo; ?></span>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="update-form">
                        <input type="text" name="todo" value="<?php echo $todo; ?>">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="update_todo">Update</button>
                    </form>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="delete-form">
                        <input type="hidden" name="index" value="<?php echo $index; ?>">
                        <button type="submit" name="delete_todo">Delete</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
    <script src="js/app.js"></script>
</body>
</html>