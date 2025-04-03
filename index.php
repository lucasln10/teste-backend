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
        
        <!-- Mensagens de status -->
        <?php if (isset($_GET['status'])): ?>
            <div class="alert alert-<?= $_GET['status'] == 'success' ? 'success' : 'danger' ?>">
                <?= $_GET['status'] == 'success' ? '✅ Corretor cadastrado com sucesso!' : '❌ Erro ao cadastrar corretor.' ?>
            </div>
        <?php endif; ?>
        
        <!-- Formulário de Cadastro -->
        <div class="card mb-5">
            <div class="card-header bg-primary text-white">
                <h2 class="h5 mb-0">Adicionar Novo Corretor</h2>
            </div>
            <div class="card-body">
                <form action="cadastrar.php" method="POST" id="corretorForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" name="cpf" 
                                   placeholder="Somente números" maxlength="11" required>
                            <div class="invalid-feedback" id="cpfError">CPF deve ter 11 números</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="creci" class="form-label">CRECI</label>
                            <input type="text" class="form-control" id="creci" name="creci" required>
                            <div class="invalid-feedback" id="creciError">Mínimo 2 caracteres</div>
                        </div>
                        
                        <div class="col-md-4">
                            <label for="nome" class="form-label">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                            <div class="invalid-feedback" id="nomeError">Mínimo 2 caracteres</div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-person-plus"></i> Cadastrar Corretor
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabela de Corretores -->
        <div class="card">
            <div class="card-header bg-dark text-white">
                <h2 class="h5 mb-0">Corretores Cadastrados</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>CPF</th>
                                <th>CRECI</th>
                                <th>Nome</th>
                                <th>Data Cadastro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require 'conexao.php';
                            $corretores = $pdo->query("SELECT * FROM corretores ORDER BY data_cadastro DESC")->fetchAll();
                            
                            if (empty($corretores)): ?>
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
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
                                </tr>
                            <?php endforeach; 
                            endif; ?>
                        </tbody>
                    </table>
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