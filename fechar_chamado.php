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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $chamado_id = $_POST['id'];
    $descricao_encerramento = $_POST['descricao_encerramento'];

    $sql = "UPDATE chamados SET status = 'Fechado', descricao_encerramento = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $descricao_encerramento, $chamado_id);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    header("Location: chamados.php");
    exit();
} else {
    $chamado_id = $_GET['id'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fechar Chamado</title>
    <link rel="stylesheet" href="styles/fechar_chamado.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Encerrar Chamado</h1>
        </header>
        <form action="fechar_chamado.php" method="post">
            <input type="hidden" name="id" value="<?php echo $chamado_id; ?>">
            <div class="form-group">
                <label for="descricao_encerramento">Descrição do Encerramento:</label>
                <textarea name="descricao_encerramento" id="descricao_encerramento" rows="5" required></textarea>
            </div>
            <input type="submit" value="Encerrar Chamado">
        </form>
        <button onclick="window.location.href='ver_chamado.php?id=<?php echo $chamado_id; ?>'">Cancelar</button>
    </div>
</body>
</html>
