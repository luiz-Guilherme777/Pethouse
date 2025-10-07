<?php

$host = "localhost";
$dbname = "sa_database";
$usuario = "root";
$senha = "";

try {
    $pdo = new PDO(dsn: "mysql:host=$host;dbname=$dbname;charset=utf8", username: $usuario, password: $senha);
    $pdo->setAttribute(attribute: PDO::ATTR_ERRMODE, value: PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>