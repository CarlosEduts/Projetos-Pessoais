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
    $hour = date('H:i');
    $user_id = $_SESSION['user_id'];

    $stmt = $db->prepare("INSERT INTO water_logs (user_id, date, hour, amount) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$user_id, $date, $hour, $amount])) {
        echo "Registro adicionado com sucesso!";
    } else {
        echo "Erro ao adicionar registro.";
    }
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM water_logs WHERE user_id = ? ORDER BY date DESC");
$stmt->execute([$user_id]);
$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sum = 0;
foreach ($logs as $log) {
    if ($log['date'] == date('Y-m-d')) {
        $sum += $log['amount'];
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
    <div class="home-container">

        <div class="home-box">
            <h2>Registrar (ml): </h2>
            <form method="post">
                <input type="number" name="amount" value="50" placeholder="Quantidade em ml" required>
                <br />
                <button type="submit">Adicionar</button>
            </form>
        </div>

        <div class="home-box">
            <h2>Meta diaria</h2>
            <h3 class="goal-percentage"></h3>
            <p class="goal"><?php echo $sum ?></p>
        </div>

        <div class="home-box">
            <h2>Histórico (Hoje): </h2>
            <table>
                <tr>
                    <th>Hora</th>
                    <th>Quantidade (ml)</th>
                </tr>
                <?php foreach ($logs as $log): ?>
                    <?php if ($log['date'] == date('Y-m-d')): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($log['hour']); ?></td>
                            <td><?php echo htmlspecialchars($log['amount']); ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
                <tr>
                    <td>Total:</td>
                    <td><?php echo htmlspecialchars($sum); ?></td>
                </tr>
            </table>
        </div>
        <a href="view.php"><button>Outras datas</button></a>
    </div>


    <script>
        let goalValue = document.querySelector('.goal')
        let percentage = document.querySelector('.goal-percentage')
        let goalDay = 3000
        
        percentage.innerText = `${((goalValue.innerText / goalDay) * 100).toFixed(2)}%`
        goalValue.innerText = `${goalValue.innerText} / ${goalDay}`
    </script>


</body>

</html>