<?php
require 'conexao.php';

// Mensagens de operação
$mensagem = '';
if (isset($_GET['status'])) {
    switch ($_GET['status']) {
        case 'success':
            $mensagem = '<div class="alert alert-success">Operação realizada com sucesso!</div>';
            break;
        case 'error':
            $mensagem = '<div class="alert alert-danger">Erro ao realizar operação.</div>';
            break;
        case 'edit':
            $mensagem = '<div class="alert alert-info">Modo edição - Atualize os dados</div>';
            break;
    }
}

// Carrega dados para edição se existir
$edicao = [];
if (isset($_GET['editar'])) {
    $stmt = $pdo->prepare("SELECT * FROM corretores WHERE id = ?");
    $stmt->execute([$_GET['editar']]);
    $edicao = $stmt->fetch();
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Corretor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Cadastro de Corretor</h1>
        
        <?= $mensagem ?>
        
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0"><?= empty($edicao) ? 'Adicionar Novo' : 'Editar' ?> Corretor</h2>
            </div>
            <div class="card-body">
                <form action="<?= empty($edicao) ? 'cadastrar.php' : 'editar.php' ?>" method="POST" id="corretorForm">
                    <?php if (!empty($edicao)): ?>
                        <input type="hidden" name="id" value="<?= $edicao['id'] ?>">
                    <?php endif; ?>
                    
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" 
                                   value="<?= $edicao['cpf'] ?? '' ?>" 
                                   placeholder="Somente números" maxlength="11" required>
                            <div class="invalid-feedback">CPF deve ter 11 números</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="creci" class="form-label">CRECI</label>
                            <input type="text" class="form-control" id="creci" name="creci" 
                                   value="<?= $edicao['creci'] ?? '' ?>" required>
                            <div class="invalid-feedback">Mínimo 2 caracteres</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" 
                                   value="<?= $edicao['nome'] ?? '' ?>" required>
                            <div class="invalid-feedback">Mínimo 2 caracteres</div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-<?= empty($edicao) ? 'person-plus' : 'check-lg' ?>"></i> 
                            <?= empty($edicao) ? 'Cadastrar' : 'Salvar' ?>
                        </button>
                        
                        <?php if (!empty($edicao)): ?>
                            <a href="index.php" class="btn btn-secondary ms-2">
                                <i class="bi bi-x-lg"></i> Cancelar
                            </a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>CPF</th>
                <th>CRECI</th>
                <th>Nome</th>
                <th>Data Cadastro</th>
                <th width="180">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $corretores = $pdo->query("SELECT * FROM corretores ORDER BY data_cadastro DESC")->fetchAll();
            
            if (empty($corretores)): ?>
                <tr>
                    <td colspan="6" class="text-center text-muted py-4">
                        Nenhum corretor cadastrado ainda
                    </td>
                </tr>
            <?php else: 
                foreach ($corretores as $corretor): 
                    $cpf_formatado = substr($corretor['cpf'], 0, 3) . '.' . 
                                     substr($corretor['cpf'], 3, 3) . '.' . 
                                     substr($corretor['cpf'], 6, 3) . '-' . 
                                     substr($corretor['cpf'], 9, 2);
            ?>
                <tr>
                    <td><?= $corretor['id'] ?></td>
                    <td><?= $cpf_formatado ?></td>
                    <td><?= htmlspecialchars($corretor['creci']) ?></td>
                    <td><?= htmlspecialchars($corretor['nome']) ?></td>
                    <td><?= date('d/m/Y H:i', strtotime($corretor['data_cadastro'])) ?></td>
                    <td class="actions">
    <!-- Botão Editar -->
                        <a href="index.php?editar=<?= $corretor['id'] ?>" 
                        class="btn btn-sm btn-warning me-1"
                        title="Editar corretor">
                            <i class="bi bi-pencil"></i> Editar
                        </a>
                        
                        <!-- Botão Excluir -->
                        <form action="excluir.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $corretor['id'] ?>">
                            <button type="submit" 
                                    class="btn btn-sm btn-danger"
                                    title="Excluir corretor"
                                    onclick="return confirm('Tem certeza que deseja excluir?')">
                                <i class="bi bi-trash"></i> Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; 
            endif; ?>
        </tbody>
    </table>
</div>

    <!-- Modal de Confirmação -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmar Exclusão</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Tem certeza que deseja excluir este corretor?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="#" id="btnConfirmarExclusao" class="btn btn-danger">Excluir</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Seu JS -->
    <script src="script.js"></script>
</body>
</html>