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

$sql = "SELECT id, nome, numero_serie, categoria, data_aquisicao, status FROM equipamentos";
$result = $conn->query($sql);
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
    <div class="container">
        <header>
            <h1>Inventário de Equipamentos</h1>
        </header>
        <div class="menu">
            <button onclick="window.location.href='adicionar_equipamento.php'">Adicionar Equipamento</button>
            <button onclick="window.location.href='chamados.php'">Ir para Chamados</button>
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
                                <a href="excluir_equipamento.php?id=<?php echo $row['id']; ?>" class="delete">❌</a>
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
</body>
</html>

<?php
$conn->close();
?>
