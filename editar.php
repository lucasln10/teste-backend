<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf'] ?? '');
        $creci = trim($_POST['creci'] ?? '');
        $nome = trim($_POST['nome'] ?? '');

        // Validações
        if (strlen($cpf) !== 11 || strlen($creci) < 2 || strlen($nome) < 2 || !$id) {
            throw new Exception("Dados inválidos");
        }

        $stmt = $pdo->prepare("UPDATE corretores SET cpf=?, creci=?, nome=? WHERE id=?");
        $stmt->execute([$cpf, $creci, $nome, $id]);

        header('Location: index.php?status=success');
        exit;
    } catch (Exception $e) {
        error_log("Erro ao editar: " . $e->getMessage());
        header('Location: index.php?status=error');
        exit;
    }
} else {
    header('Location: index.php');
    exit;
}