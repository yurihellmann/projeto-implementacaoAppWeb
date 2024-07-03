<?php
session_start(); //inicia a sessão
if (!isset($_SESSION['usuario'])) {
    header("Location: index.html");
    exit();
}
// linhas 3 a 6 - verifica se a variável usuario está definida. Caso não esteja, redireciona o usuário novamente a página de login e encerra a conexão com banco de dados

//define as variáveis de conexão com banco de dados: servidor, usuário, senha e nome do banco
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "PROJETO_FACUL";
//define as variáveis de conexão com banco de dados: servidor, usuário, senha e nome do banco

$conn = new mysqli($servername, $username, $password, $dbname);// cria nova conexão

//verifica se ocorreu algum erro na conexão e se houver, exibe uma mensagem e encerra a execução do script
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
//verifica se ocorreu algum erro na conexão e se houver, exibe uma mensagem e encerra a execução do script

if ($_SERVER["REQUEST_METHOD"] == "POST") { //verifica se o metodo de requisição é o POST, garantindo que o código só será executado quando o formulário for enviado pelo método POST
    //sanitiza os dados recebidos, ajudando a evitar ataques de SQL Injection e atribui os dados as variáveis correspondentes
    $titulo = $conn->real_escape_string($_POST['titulo']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $modulo = $conn->real_escape_string($_POST['modulo']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $setor = $conn->real_escape_string($_POST['setor']);
    $status = 'Aberto'; //define o status padrão como 'Aberto', padrão para novos chamados
    //sanitiza os dados recebidos, ajudando a evitar ataques de SQL Injection e atribui os dados as variáveis correspondentes

    //inserção no banco de dados
    $sql = "INSERT INTO chamados (titulo, descricao, modulo, usuario, setor, status, data_criacao) VALUES ('$titulo', '$descricao', '$modulo', '$usuario', '$setor', '$status', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: chamados.php");
        exit();
    } else {
        echo "Erro ao abrir chamado: " . $conn->error;
    }
}
    //inserção no banco de dados

$conn->close(); //encerra a conexão com o banco
?>
