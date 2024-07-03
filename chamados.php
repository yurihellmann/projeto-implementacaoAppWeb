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
// conexão com banco de dados

$filtro = isset($_GET['filtro']) ? $_GET['filtro'] : 'abertos'; //obtém o valor do filtro da página a partir da URL. Caso não estiver definido, define como padrão o valor 'abertos'

//lógica do filtro: define a consulta SQL e o título da página conforme o filtro selecionado
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
//lógica do filtro: define a consulta SQL e o título da página conforme o filtro selecionado

$result = $conn->query($sql); //executa a consulta SQL com base nos parametros do filtro e armazena na variável
?>

<!--estrutura da página-->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $titulo; ?></title> <!título dinâmico da página com base no filtro selecionado->
    <link rel="stylesheet" href="styles/chamados.css">
</head>
<body>
    <div class="container">
        <header>
            <h1><?php echo $titulo; ?></h1>
        </header>
        <div class="menu"> <!--botões de navegação-->
            <button onclick="window.location.href='abrir_chamado.html'">Abrir Chamado</button>
            <button onclick="window.location.href='inventario.php'">Gerenciamento de Inventário</button>
            <button onclick="window.location.href='logout.php'">Sair</button>
        </div> <!--botões de navegação-->
        <div class="filtros"> <!--botões de filtro dos status dos chamados-->
            <button onclick="window.location.href='chamados.php?filtro=abertos'">Abertos</button>
            <button onclick="window.location.href='chamados.php?filtro=fechados'">Fechados</button>
            <button onclick="window.location.href='chamados.php?filtro=todos'">Todos</button>
        </div> <!--botões de filtro dos status dos chamados-->
        <table> <!--tabela de exibição dos chamados-->
            <thead> <!---define os títulos das colunas-->
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
            </thead> <!---define os títulos das colunas-->
            <tbody> <!--corpo da tabela é definido dinamicamente-->
                <?php if ($result->num_rows > 0): ?> <!--verifica se há registros retornados pela consulta-->
                    <?php while($row = $result->fetch_assoc()): ?> <!--itera sobre cada linha de resultado da consulta e exibe os dados nas colunas da tabela-->
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
            </tbody> <!--corpo da tabela é definido dinamicamente-->
        </table> <!--tabela de exibição dos chamados-->
    </div>
</body>
</html>
<!--estrutura da página-->

<?php
$conn->close(); //encerra a conexão com o banco
?>
