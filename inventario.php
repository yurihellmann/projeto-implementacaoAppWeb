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

$sql = "SELECT id, nome, numero_serie, categoria, data_aquisicao, status, marca, modelo FROM equipamentos";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciamento de Inventário</title>
    <link rel="stylesheet" href="styles/inventario.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Gerenciamento de Inventário</h1>
        </header>
        <div class="menu">
            <button onclick="window.location.href='adicionar_equipamento.php'">Adicionar Equipamento</button>
            <button onclick="window.location.href='logout.php'">Sair</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Número de Série</th>
                    <th>Categoria</th>
                    <th>Data de Aquisição</th>
                    <th>Status</th>
                    <th>Marca</th>
                    <th>Modelo</th>
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
                            <td><?php echo $row["marca"]; ?></td>
                            <td><?php echo $row["modelo"]; ?></td>
                            <td>
                                <form action="inventario.php" method="POST" class="delete-form">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <input type="hidden" name="confirm_delete" value="1">
                                    <button type="submit" class="delete-button"><i class="fas fa-times"></i></button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9">Nenhum equipamento encontrado</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_POST['confirm_delete'])): ?>
    <div class="popup">
        <div class="popup-content">
            <h2>Confirmar Exclusão</h2>
            <p>Tem certeza de que deseja excluir este item?</p>
            <form action="excluir_equipamento.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $_POST['id']; ?>">
                <button type="submit" name="delete" class="btn-confirm">Confirmar</button>
                <button type="submit" name="cancel" class="btn-cancel">Cancelar</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>

<?php
$conn->close();
?>
