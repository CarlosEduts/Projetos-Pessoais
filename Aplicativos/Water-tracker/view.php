<?php
include('db.php');
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM water_logs WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Consumo de Água</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Histórico de Consumo de Água</h2>
    <table>
        <tr>
            <th>Data</th>
            <th>Quantidade (ml)</th>
        </tr>
        <?php foreach ($logs as $log): ?>
        <tr>
            <td><?php echo htmlspecialchars($log['date']); ?></td>
            <td><?php echo htmlspecialchars($log['amount']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="home.php">Registrar novo consumo</a>
</body>
</html>
