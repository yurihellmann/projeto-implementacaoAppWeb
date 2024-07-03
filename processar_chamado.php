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

// Criando a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $modulo = $conn->real_escape_string($_POST['modulo']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $setor = $conn->real_escape_string($_POST['setor']);
    $status = 'Aberto'; // Define o status padrão como 'Aberto'

    $sql = "INSERT INTO chamados (titulo, descricao, modulo, usuario, setor, status, data_criacao) VALUES ('$titulo', '$descricao', '$modulo', '$usuario', '$setor', '$status', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: chamados.php");
        exit();
    } else {
        echo "Erro ao abrir chamado: " . $conn->error;
    }
}

$conn->close();
?>
