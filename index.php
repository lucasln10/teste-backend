<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastro de Corretor</h1>
    
    <?php
    // Exibir mensagem de sucesso/erro
    if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success') {
            echo '<div class="alert success">Corretor cadastrado com sucesso!</div>';
        } elseif ($_GET['status'] == 'error') {
            echo '<div class="alert error">Erro ao cadastrar corretor.</div>';
        }
    }
    ?>
    
    <form action="cadastrar.php" method="POST" id="corretorForm">
        <div class="input-row">
            <div class="input-field">
                <input type="text" id="cpf" name="cpf" placeholder="Digite seu CPF" maxlength="11" required>
                <div class="error-message" id="cpfError">CPF deve ter exatamente 11 números</div>
            </div>
            <div class="input-field">
                <input type="text" id="creci" name="creci" placeholder="Digite seu Creci" required>
                <div class="error-message" id="creciError">Creci deve ter pelo menos 2 caracteres</div>
            </div>
        </div>
        
        <hr>
        
        <div class="input-field">
            <h2>Digite seu nome</h2>
            <input type="text" id="nome" name="nome" placeholder="Digite seu nome completo" required>
            <div class="error-message" id="nomeError">Nome deve ter pelo menos 2 caracteres</div>
        </div>
        
        <button type="submit" class="submit-btn">Enviar</button>
    </form>

    <script src="script.js"></script>
</body>
</html>