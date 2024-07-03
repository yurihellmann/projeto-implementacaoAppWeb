<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Equipamento</title>
    <link rel="stylesheet" href="styles/adicionar_equipamento.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Adicionar Equipamento</h1>
        </header>
        <div class="form-container">
            <form action="processar_equipamento.php" method="POST">
                <label for="nome">Nome do Equipamento:</label>
                <input type="text" id="nome" name="nome" required>

                <label for="numero_serie">Número de Série:</label>
                <input type="text" id="numero_serie" name="numero_serie" required>

                <label for="categoria">Categoria:</label>
                <input type="text" id="categoria" name="categoria" required>

                <label for="data_aquisicao">Data de Aquisição:</label>
                <input type="date" id="data_aquisicao" name="data_aquisicao" required>

                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Em uso">Em uso</option>
                    <option value="Disponível">Disponível</option>
                    <option value="Sucateado">Sucateado</option>
                </select>

                <label for="usuario">Usuário:</label>
                <input type="text" id="usuario" name="usuario" required>

                <div class="buttons">
                    <button type="button" class="btn-cancelar" onclick="window.history.back();">Cancelar</button>
                    <button type="submit">Adicionar Equipamento</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
