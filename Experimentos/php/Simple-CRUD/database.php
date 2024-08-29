<?php
$databaseFile = 'users.db';

try {
    $pdo = new PDO("sqlite:$databaseFile");

    // Configurando o modo de erro do PDO para exceções
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criando a tabela de usuários se não existir
    $createTableQuery = "
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE
        )
    ";
    $pdo->exec($createTableQuery);
} catch (PDOException $e) {
    die("Erro ao conectar ao db: " . $e->getMessage());
}
