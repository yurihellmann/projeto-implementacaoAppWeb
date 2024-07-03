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

$chamado_id = $_GET['id'];
$sql = "SELECT id, titulo, descricao, status, descricao_encerramento, data_criacao FROM chamados WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $chamado_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $chamado = $result->fetch_assoc();
} else {
    echo "Chamado não encontrado.";
    exit();
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Chamado</title>
    <link rel="stylesheet" href="styles/ver_chamado.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Detalhes do Chamado</h1>
        </header>
        <div class="chamado-detalhes">
            <p><strong>ID:</strong> <?php echo $chamado['id']; ?></p>
            <p><strong>Título:</strong> <?php echo $chamado['titulo']; ?></p>
            <p><strong>Descrição:</strong> <?php echo $chamado['descricao']; ?></p>
            <p><strong>Status:</strong> <?php echo $chamado['status']; ?></p>
            <p><strong>Data de Criação:</strong> <?php echo $chamado['data_criacao']; ?></p>
            <?php if ($chamado['status'] == 'Fechado'): ?>
                <p><strong>Descrição do Encerramento:</strong> <?php echo $chamado['descricao_encerramento']; ?></p>
            <?php endif; ?>
            <div class="menu">
                <?php if ($chamado['status'] != 'Fechado'): ?>
                    <button onclick="window.location.href='fechar_chamado.php?id=<?php echo $chamado['id']; ?>'">Fechar Chamado</button>
                <?php endif; ?>
                <button onclick="window.location.href='chamados.php'">Voltar</button>
            </div>
        </div>
    </div>
</body>
</html>
