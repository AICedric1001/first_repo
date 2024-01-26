<?php
session_start();
include_once("config.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT username, password FROM User WHERE username = ?");
    $stmt->bind_param("s", $username);
    
    $stmt->execute();
    
    $stmt->store_result();
    $stmt->bind_result($savedUsername, $hashedPassword);

    if ($stmt->fetch() && password_verify($password, $hashedPassword)) {
    
        $_SESSION['user'] = $username;
        header("Location: home.php");
        exit();
    } else {
        $loginError = "Login failed. Please check your username and password. Or click Register.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css"> 
    <style>
    
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>

        <?php if (isset($loginError)) : ?>
            <p class="error-message"><?php echo $loginError; ?></p>
        <?php endif; ?>

        <form method="post" action="">
            <label for="username">Username:</label>
            <input type="text" name="username" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" required><br>

            <input type="submit" value="Login">
            <a href='register.php'>Register here</a>.
        </form>
    </div>
</body>
</html>
