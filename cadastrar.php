<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = preg_replace('/[^0-9]/', '', $_POST['cpf']);
    $creci = trim($_POST['creci']);
    $nome = trim($_POST['nome']);

    // Validações básicas
    if (strlen($cpf) !== 11 || strlen($creci) < 2 || strlen($nome) < 2) {
        header('Location: index.php?status=error');
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO corretores (cpf, creci, nome) VALUES (:cpf, :creci, :nome)");
        $stmt->bindParam(':cpf', $cpf);
        $stmt->bindParam(':creci', $creci);
        $stmt->bindParam(':nome', $nome);
        
        if ($stmt->execute()) {
            header('Location: index.php?status=success');
        } else {
            header('Location: index.php?status=error');
        }
    } catch (PDOException $e) {
        header('Location: index.php?status=error');
    }
} else {
    header('Location: index.php');
}
?>