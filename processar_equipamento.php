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
    $nome = $conn->real_escape_string($_POST['nome']);
    $numero_serie = $conn->real_escape_string($_POST['numero_serie']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $data_aquisicao = $conn->real_escape_string($_POST['data_aquisicao']);
    $status = $conn->real_escape_string($_POST['status']);
    $usuario = $conn->real_escape_string($_POST['usuario']);

    $sql = "INSERT INTO equipamentos (nome, numero_serie, categoria, data_aquisicao, status, usuario) VALUES ('$nome', '$numero_serie', '$categoria', '$data_aquisicao', '$status', '$usuario')";

    if ($conn->query($sql) === TRUE) {
        header("Location: inventario.php");
        exit();
    } else {
        echo "Erro ao adicionar equipamento: " . $conn->error;
    }
}

$conn->close();
?>
