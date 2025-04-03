<?php
require 'conexao.php';

// Habilite para ver erros (remova em produção)
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Verifica se é uma requisição POST e se o ID existe
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['id'])) {
        throw new Exception("Requisição inválida");
    }

    // Filtra e valida o ID
    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if (!$id || $id <= 0) {
        throw new Exception("ID inválido");
    }

    // Prepara e executa a exclusão
    $stmt = $pdo->prepare("DELETE FROM corretores WHERE id = ?");
    $stmt->execute([$id]);

    // Verifica se alguma linha foi afetada
    if ($stmt->rowCount() === 0) {
        throw new Exception("Nenhum registro encontrado para exclusão");
    }

    // Redireciona com mensagem de sucesso
    header('Location: index.php?status=success');
    exit;

} catch (Exception $e) {
    // Registra o erro completo no log do servidor
    error_log("ERRO NA EXCLUSÃO: " . $e->getMessage() . " - ID: " . ($_POST['id'] ?? 'NULL'));
    
    // Redireciona com mensagem de erro
    header('Location: index.php?status=error');
    exit;
}