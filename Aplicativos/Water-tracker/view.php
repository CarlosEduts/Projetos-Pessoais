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

$dates = [];

foreach ($logs as $log) {
    if (!in_array($log['date'], $dates)) {
        array_push($dates, $log['date']);
    }
}

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
    <div class="home-container">
    <h2>Histórico de Consumo de Água</h2>

<?php foreach ($dates as $date): ?>
    <table class="home-box">
        <tr>
            <th><?php echo htmlspecialchars($date); ?></th>
            <th>Quantidade (ml)</th>
        </tr>

        <?php foreach ($logs as $log): ?>
            <?php if ($log['date'] == $date): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($log['hour']); ?></td>
                        <td><?php echo htmlspecialchars($log['amount']); ?></td>
                    </tr>
                <?php endif; ?>
        <?php endforeach; ?>
    </table>
<?php endforeach; ?>

<a href="home.php">Registrar novo consumo</a>
    </div>
</body>

</html>