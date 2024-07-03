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

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'abertos';

switch ($filtro) {
    case 'fechados':
        $sql = "SELECT id, titulo, status, data_criacao, modulo, usuario, setor FROM chamados WHERE status = 'Fechado'";
        $titulo = "Chamados Fechados";
        break;
    case 'todos':
        $sql = "SELECT id, titulo, status, data_criacao, modulo, usuario, setor FROM chamados";
        $titulo = "Todos os Chamados";
        break;
    default:
        $sql = "SELECT id, titulo, status, data_criacao, modulo, usuario, setor FROM chamados WHERE status != 'Fechado'";
        $titulo = "Chamados Abertos";
        break;
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title>
    <link rel="stylesheet" href="styles/chamados.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo $titulo; ?></h1>
        </header>
        <div class="menu">
            <button onclick="window.location.href='abrir_chamado.html'">Abrir Chamado</button>
            <button onclick="window.location.href='inventario.php'">Gerenciamento de Inventário</button>
            <button onclick="window.location.href='logout.php'">Sair</button>
        </div>
        <div class="filtros">
            <button onclick="window.location.href='chamados.php?filtro=abertos'">Abertos</button>
            <button onclick="window.location.href='chamados.php?filtro=fechados'">Fechados</button>
            <button onclick="window.location.href='chamados.php?filtro=todos'">Todos</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Status</th>
                    <th>Data de Criação</th>
                    <th>Módulo</th>
                    <th>Usuário</th>
                    <th>Setor</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row["id"]; ?></td>
                            <td><?php echo $row["titulo"]; ?></td>
                            <td><?php echo $row["status"]; ?></td>
                            <td><?php echo date("d/m/Y H:i:s", strtotime($row["data_criacao"])); ?></td>
                            <td><?php echo ucfirst($row["modulo"]); ?></td>
                            <td><?php echo $row["usuario"]; ?></td>
                            <td><?php echo $row["setor"]; ?></td>
                            <td><a href="ver_chamado.php?id=<?php echo $row['id']; ?>">👁️</a></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">Nenhum chamado encontrado</td>
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
