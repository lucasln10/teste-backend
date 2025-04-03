<?php
require 'conexao.php';

try {
    // Validações
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
    $creci = trim($_POST['creci'] ?? '');
    $nome = trim($_POST['nome'] ?? '');

    if (strlen($cpf) !== 11) {
        throw new Exception("CPF deve ter 11 dígitos");
    }

    if (strlen($creci) < 2) {
        throw new Exception("CRECI deve ter pelo menos 2 caracteres");
    }

    if (strlen($nome) < 2) {
        throw new Exception("Nome deve ter pelo menos 2 caracteres");
    }

    // Verifica se CPF já existe
    $stmt = $pdo->prepare("SELECT id FROM corretores WHERE cpf = ?");
    $stmt->execute([$cpf]);
    
    if ($stmt->rowCount() > 0) {
        throw new Exception("CPF já cadastrado");
    }

    // Insere no banco
    $stmt = $pdo->prepare("INSERT INTO corretores (cpf, creci, nome) VALUES (?, ?, ?)");
    $stmt->execute([$cpf, $creci, $nome]);

    header('Location: index.php?status=success');
} catch (Exception $e) {
    error_log("Erro ao cadastrar: " . $e->getMessage());
    header('Location: index.php?status=error');
}
?>