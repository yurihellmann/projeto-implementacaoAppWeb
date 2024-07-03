<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PROJETO_FACUL";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $sql = "DELETE FROM equipamentos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
    header("Location: inventario.php");
    exit();
}

$sql = "SELECT id, nome, numero_serie, categoria, data_aquisicao, status FROM equipamentos";
$result = $conn->query($sql);

$showConfirmation = false;
$equipmentToDelete = null;

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['confirm_delete'])) {
    $showConfirmation = true;
    $equipmentToDelete = intval($_GET['confirm_delete']);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Inventário</title>
    <link rel="stylesheet" href="styles/inventario.css">
</head>
<body>
    <header>
        <h1>Gerenciamento de Inventário</h1>
        <div class="menu">
            <button onclick="window.location.href='chamados.php'">Chamados</button>
            <button onclick="window.location.href='adicionar_equipamento.php'">Adicionar Equipamento</button>
        </div>
    </header>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Número de Série</th>
                    <th>Categoria</th>
                    <th>Data de Aquisição</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["nome"]; ?></td>
                            <td><?php echo $row["numero_serie"]; ?></td>
                            <td><?php echo $row["categoria"]; ?></td>
                            <td><?php echo $row["data_aquisicao"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td>
                                <a href="inventario.php?confirm_delete=<?php echo $row['id']; ?>" class="delete">&times;</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">Nenhum equipamento encontrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if ($showConfirmation): ?>
        <div class="popup-container">
            <div class="popup">
                <h2>Confirmar Exclusão</h2>
                <p>Tem certeza que deseja excluir este equipamento?</p>
                <form method="post" action="inventario.php">
                    <input type="hidden" name="id" value="<?php echo $equipmentToDelete; ?>">
                    <button type="submit" class="confirm">Confirmar</button>
                    <button type="button" class="cancel" onclick="window.location.href='inventario.php'">Cancelar</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>