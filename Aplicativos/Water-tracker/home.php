<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $amount = $_POST['amount'];
    $date = date('Y-m-d');
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("INSERT INTO water_logs (user_id, date, amount) VALUES (?, ?, ?)");
    if ($stmt->execute([$user_id, $date, $amount])) {
        echo "Registro adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar registro.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Consumo de Água</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registrar Consumo de Água</h2>
    <form method="post">
        <input type="number" name="amount" placeholder="Quantidade em ml" required>
        <button type="submit">Adicionar</button>
    </form>
    <a href="view.php">Ver histórico</a>
</body>
</html>
