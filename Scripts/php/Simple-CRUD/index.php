<?php
include 'database.php';

// Funções CRUD
function createUser($pdo, $name, $email)
{
    $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

function readUsers($pdo)
{
    $stmt = $pdo->query("SELECT * FROM users");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function updateUser($pdo, $id, $name, $email)
{
    $stmt = $pdo->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->execute();
}

function deleteUser($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
}

// Processando requisições
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create'])) {
        createUser($pdo, $_POST['name'], $_POST['email']);
    } elseif (isset($_POST['update'])) {
        updateUser($pdo, $_POST['id'], $_POST['name'], $_POST['email']);
    }
}

if (isset($_GET['delete'])) {
    deleteUser($pdo, $_GET['delete']);
}

$users = readUsers($pdo);
?>

<!DOCTYPE html>
<html>

<head>
    <title>CRUD com SQLite</title>
</head>

<body>
    <h1>Gerenciamento de Usuários</h1>

    <!-- Formulário para criar um novo usuário -->
    <h2>Criar Usuário</h2>
    <form method="post">
        Nome: <input type="text" name="name" required>
        Email: <input type="email" name="email" required>
        <button type="submit" name="create">Criar</button>
    </form>

    <!-- Lista de usuários -->
    <h2>Lista de Usuários</h2>
    <?php if ($users): ?>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Ações</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td>
                        <a href="?edit=<?php echo $user['id']; ?>">Editar</a>
                        <a href="?delete=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    <?php else: ?>
        <p>Não há usuários cadastrados</p>
    <?php endif; ?>

    <!-- Formulário para editar um usuário existente -->
    <?php if (isset($_GET['edit'])): ?>
        <?php
        $editId = $_GET['edit'];
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $editId);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        ?>
        <h2>Editar Usuário</h2>
        <form method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            Nome: <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            Email: <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            <button type="submit" name="update">Atualizar</button>
        </form>
    <?php endif; ?>
</body>

</html>