<?php
// public/index.php

require_once '../src/User.php';

$userModel = new User();
$message = '';

// Handle form submission for creating/updating users
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (isset($_POST['id']) && !empty($_POST['id'])) { // Update existing user
        $userModel->update($_POST['id'], $name, $email, $password);
        $message = 'User updated successfully.';
    } else { // Create new user
        $userModel->create($name, $email, $password);
        $message = 'User created successfully.';
    }
}

// Handle deletion
if (isset($_GET['delete'])) {
    $userModel->delete($_GET['delete']);
    $message = 'User deleted successfully.';
}

// Fetch all users
$users = $userModel->readAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>User Management</h1>

    <?php if ($message): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="hidden" name="id" value="<?php echo isset($user) ? htmlspecialchars($user['id']) : ''; ?>">
        <input type="text" name="name" placeholder="Name" required value="<?php echo isset($user) ? htmlspecialchars($user['name']) : ''; ?>">
        <input type="email" name="email" placeholder="Email" required value="<?php echo isset($user) ? htmlspecialchars($user['email']) : ''; ?>">
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Submit</button>
    </form>

    <h2>Users List</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        <?php foreach ($users as $user): ?>
            <tr>
                <td><?php echo htmlspecialchars($user['id']); ?></td>
                <td><?php echo htmlspecialchars($user['name']); ?></td>
                <td><?php echo htmlspecialchars($user['email']); ?></td>
                <td>
                    <a href="?edit=<?php echo $user['id']; ?>">Edit</a>
                    <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
