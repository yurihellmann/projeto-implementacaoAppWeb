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

$message = "";
$showConfirmation = false;
$deleteId = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_id"])) {
        $deleteId = $_POST["delete_id"];
        $showConfirmation = true;
    } elseif (isset($_POST["confirm_delete"])) {
        $id = $_POST["confirm_delete"];
        $sql = "DELETE FROM equipamentos WHERE id = $id";
        if ($conn->query($sql) === TRUE) {
            $message = "Equipamento excluído com sucesso.";
        } else {
            $message = "Erro ao excluir o equipamento: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventário de Equipamentos</title>
    <link rel="stylesheet" href="styles/inventario.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Inventário de Equipamentos</h1>
        </header>
        <div class="menu">
            <button onclick="window.location.href='adicionar_equipamento.php'">Adicionar Equipamento</button>
            <button onclick="window.location.href='chamados.php'">Gerenciamento de Chamados</button>
            <button onclick="window.location.href='logout.php'">Sair</button>
        </div>

        <?php if ($message): ?>
            <div class="alert"><?php echo $message; ?></div>
        <?php endif; ?>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Número de Série</th>
                    <th>Categoria</th>
                    <th>Data de Aquisição</th>
                    <th>Status</th>
                    <th>Usuário</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM equipamentos";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["nome"] . "</td>";
                        echo "<td>" . $row["numero_serie"] . "</td>";
                        echo "<td>" . $row["categoria"] . "</td>";
                        echo "<td>" . date("d/m/Y", strtotime($row["data_aquisicao"])) . "</td>";
                        echo "<td>" . $row["status"] . "</td>";
                        echo "<td>" . $row["usuario"] . "</td>";
                        echo "<td>";
                        echo "<a href='editar_equipamento.php?id=" . $row["id"] . "'>✏️</a> ";
                        echo "<form method='POST' action='' style='display:inline;'>";
                        echo "<input type='hidden' name='delete_id' value='" . $row["id"] . "'>";
                        echo "<button type='submit' style='background:none;border:none;color:red;'>🗑️</button>";
                        echo "</form>";
                        echo "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>Nenhum equipamento encontrado.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <?php if ($showConfirmation): ?>
            <div class="overlay">
                <div class="confirmation-box">
                    <p>Tem certeza que deseja excluir este equipamento?</p>
                    <form method="POST" action="">
                        <input type="hidden" name="confirm_delete" value="<?php echo $deleteId; ?>">
                        <button type="button" onclick="window.location.href='inventario.php'">Cancelar</button>
                        <button type="submit">Confirmar</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
