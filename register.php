<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="login-box">
            <h2>Cadastro</h2>
            <?php if (isset($_GET['error'])): ?>
                <div class="error">Email it has register or credentials invalids !</div>
            <?php endif; ?>
            <form action="auth.php" method="POST">
                <input type="hidden" name="action" value="register">
                <div class="input-group">
                    <label for="name">Name</label>
                    <input type="name" name="name" id="name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            <p class="link">You have a account ?<a href='index.php'>Login</a></p>
        </div>
    </div>
</body>

</html>