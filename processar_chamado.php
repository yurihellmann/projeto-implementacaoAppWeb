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
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $modulo = $_POST['modulo'];
    $usuario = $_POST['usuario'];
    $setor = $_POST['setor'];
    $status = "Aberto";
    $data_criacao = date("Y-m-d H:i:s");

    $sql = "INSERT INTO chamados (titulo, descricao, modulo, usuario, setor, status, data_criacao) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $titulo, $descricao, $modulo, $usuario, $setor, $status, $data_criacao);

    if ($stmt->execute()) {
        header("Location: chamados.php");
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
