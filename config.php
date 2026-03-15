<?php
$host = 'localhost';
$dbname = 'system_manager';
$user = 'phpmyadmin';
$password = 'wiyigk66';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", 'phpmyadmin', 'wiyigk66');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'conectou';
    } catch(PDOException $e) {
        die('Erro na conexão: '.$e->getMessage());
    }
?>