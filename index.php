<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: /pages/dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="login-box">
            <h2>Login</h2>
            <?php if(isset($GET['error'])): ?>
                <div class="error">Email or password invalid !</div>
            <?php endif; ?>
            <?php if(isset($GET['registered'])): ?>
                <div class="success">Registration successful!</div>
            <?php endif; ?>
            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button class="btn" type="submit">Login</button>
            </form>
            
            <p class="link">Don't have an account ? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>