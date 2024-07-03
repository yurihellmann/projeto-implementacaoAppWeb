<?php
session_start();

try {
    // Conectar ao banco de dados
    $conn = new PDO('mysql:host=localhost;dbname=PROJETO_FACUL', 'root', '');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        // Consulta ao banco de dados para obter o hash da senha do usuário
        $sql = "SELECT senha FROM usuarios WHERE usuario = :usuario";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':usuario', $usuario);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_senha = $row['senha'];

            // Verificar a senha
            if (password_verify($senha, $hashed_senha)) {
                // Sucesso na autenticação
                $_SESSION['usuario'] = $usuario;
                header("Location: chamados.php");
                exit();
            } else {
                // Senha incorreta
                $error_message = "Usuário ou senha incorretos.";
            }
        } else {
            // Usuário não encontrado
            $error_message = "Usuário ou senha incorretos.";
        }
    }
} catch(PDOException $e) {
    $error_message = "Erro: " . $e->getMessage();
}

$conn = null;
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles/login.css">
</head>
<body>
    <div class="login">
        <form action="login.php" method="POST" class="formLogin">
            <h1>Login</h1>
            <p>Digite os seus dados de acesso no campo abaixo.</p>
            <?php if (isset($error_message)): ?>
                <p style="color: red;"><?php echo $error_message; ?></p>
            <?php endif; ?>
            <label for="usuario">Usuário</label>
            <input type="text" name="usuario" id="usuario" placeholder="Digite seu usuário" autofocus="true" required />
            <label for="senha">Senha</label>
            <input type="password" name="senha" id="senha" placeholder="Digite sua senha" required />
            <input type="submit" value="Acessar" class="btn" />
        </form>
    </div>
</body>
</html>
