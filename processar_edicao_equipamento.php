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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $nome = $conn->real_escape_string($_POST['nome']);
    $numero_serie = $conn->real_escape_string($_POST['numero_serie']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $data_aquisicao = $conn->real_escape_string($_POST['data_aquisicao']);
    $status = $conn->real_escape_string($_POST['status']);
    $usuario = $conn->real_escape_string($_POST['usuario']);

    $sql = "UPDATE equipamentos SET nome='$nome', numero_serie='$numero_serie', categoria='$categoria', data_aquisicao='$data_aquisicao', status='$status', usuario='$usuario' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: inventario.php"); // Redirecionar para inventário
        exit();
    } else {
        echo "Erro ao atualizar equipamento: " . $conn->error;
    }
} else {
    header("Location: editar_equipamento.php?id=$id"); // Redirecionar de volta ao formulário de edição em caso de falha
}

$conn->close();
?>
