<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");
    $stmt->execute(['username' => $username, 'password' => $password]);

    header('Location: signin.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Signup</title>
</head>

<body>
    <h2>Signup</h2>
    <form action="signup.php" method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit">Signup</button>
    </form>
    <p>Already have an account? <a href="signin.php">Sign in here</a>.</p>
</body>

</html>