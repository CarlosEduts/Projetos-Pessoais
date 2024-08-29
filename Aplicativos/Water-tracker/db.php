<?php

$db = new PDO('sqlite:water_tracker.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Tabela de usuários
$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    username TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
)");

// Tabela de registros de água
$db->exec("CREATE TABLE IF NOT EXISTS water_logs (
    id INTEGER PRIMARY KEY,
    user_id INTEGER,
    date TEXT,
    amount INTEGER,
    FOREIGN KEY(user_id) REFERENCES users(id)
)");
