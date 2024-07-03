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
$conn = new mysqli($servername, $username, $password, $dbname); // cria nova conexão

//verifica se ocorreu algum erro na conexão e se houver, exibe uma mensagem e encerra a execução do script
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}
//verifica se ocorreu algum erro na conexão e se houver, exibe uma mensagem e encerra a execução do script

$chamadoId = isset($_GET['id']) ? $_GET['id'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $descricao_encerramento = $conn->real_escape_string($_POST['descricao_encerramento']);
    $sql = "UPDATE chamados SET status='Fechado', descricao_encerramento='$descricao_encerramento' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: chamados.php");
        exit();
    } else {
        echo "Erro ao fechar o chamado: " . $conn->error;
    }
}

$sql = "SELECT id, titulo, descricao FROM chamados WHERE id = $chamadoId";
$result = $conn->query($sql);
$chamado = $result->fetch_assoc();

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
            <h1>Fechar Chamado</h1>
        </header>
        <div class="form-container">
            <form action="fechar_chamado.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $chamado['id']; ?>">

                <label for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" value="<?php echo $chamado['titulo']; ?>" disabled>

                <label for="descricao">Descrição:</label>
                <textarea id="descricao" name="descricao" rows="4" disabled><?php echo $chamado['descricao']; ?></textarea>

                <label for="descricao_encerramento">Descrição do Encerramento:</label>
                <textarea id="descricao_encerramento" name="descricao_encerramento" rows="4" required></textarea>

                <div class="buttons">
                    <button type="button" class="btn-cancelar" onclick="window.history.back();">Cancelar</button>
                    <button type="submit">Fechar Chamado</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
