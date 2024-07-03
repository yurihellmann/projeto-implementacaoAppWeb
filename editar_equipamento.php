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

// Criando conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Inicializando variável
$equipamento = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nome = $conn->real_escape_string($_POST['nome']);
    $numero_serie = $conn->real_escape_string($_POST['numero_serie']);
    $categoria = $conn->real_escape_string($_POST['categoria']);
    $data_aquisicao = $conn->real_escape_string($_POST['data_aquisicao']);
    $status = $conn->real_escape_string($_POST['status']);
    $usuario = $conn->real_escape_string($_POST['usuario']);

    $updateSql = "UPDATE equipamentos SET nome='$nome', numero_serie='$numero_serie', categoria='$categoria', data_aquisicao='$data_aquisicao', status='$status', usuario='$usuario' WHERE id=$id";
    if ($conn->query($updateSql) === TRUE) {
        echo "<p>Equipamento atualizado com sucesso!</p>";
    } else {
        echo "<p>Erro ao atualizar equipamento: " . $conn->error . "</p>";
    }
} else if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $selectSql = "SELECT * FROM equipamentos WHERE id = $id";
    $result = $conn->query($selectSql);
    if ($result->num_rows > 0) {
        $equipamento = $result->fetch_assoc();
    } else {
        echo "<p>Equipamento não encontrado.</p>";
        exit();
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipamento</title>
    <link rel="stylesheet" href="styles/editar_equipamento.css">
</head>
<body>
<div class="container">
    <header>
        <h1>Editar Equipamento</h1>
    </header>
    <?php if ($equipamento): ?>
    <div class="form-container">
        <form action="processar_edicao_equipamento.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $equipamento['id']; ?>">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo $equipamento['nome']; ?>" required>
    
            <label for="numero_serie">Número de Série:</label>
            <input type="text" id="numero_serie" name="numero_serie" value="<?php echo $equipamento['numero_serie']; ?>" required>
    
            <label for="categoria">Categoria:</label>
            <input type="text" id="categoria" name="categoria" value="<?php echo $equipamento['categoria']; ?>" required>
    
            <label for="data_aquisicao">Data de Aquisição:</label>
            <input type="date" id="data_aquisicao" name="data_aquisicao" value="<?php echo $equipamento['data_aquisicao']; ?>" required>
    
            <label for="status">Status:</label>
            <select id="status" name="status" required>
                <option value="Em uso" <?php echo $equipamento['status'] == 'Em uso' ? 'selected' : ''; ?>>Em uso</option>
                <option value="Disponível" <?php echo $equipamento['status'] == 'Disponível' ? 'selected' : ''; ?>>Disponível</option>
                <option value="Sucateado" <?php echo $equipamento['status'] == 'Sucateado' ? 'selected' : ''; ?>>Sucateado</option>
            </select>
    
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" value="<?php echo $equipamento['usuario']; ?>" required>
    
            <div class="buttons">
                <button type="button" class="btn-cancelar" onclick="window.history.back();">Cancelar</button>
                <button type="submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
