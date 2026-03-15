<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php"); // redireciona para login se não estiver logado
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>makakos</p>
    <p>aqui makako <a href="logout.php">Sair</a></p>
</body>
</html>