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
        <form action="processar_equipamento.php" method="POST" class="formEquipamento">
            <label for="nome">Nome:</label>
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

            <div class="form-buttons">
                <button type="button" class="cancel-button" onclick="window.location.href='inventario.php'">Cancelar</button>
                <input type="submit" value="Adicionar">
            </div>
        </form>
    </div>
</body>
</html>
