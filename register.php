<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
</head>

<body>
    <div class="container">
        <div class="login_box">
            <h2>Cadastro</h2>
            <?php if (isset($_GET['error'])): ?>
                <div class="error">Email já cadastrado ou dados inseridos invalidos !</div>
            <?php endif; ?>

        </div>
    </div>
</body>

</html>