function confirmarExclusao(id) {
    const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
    const btnConfirmar = document.getElementById('btnConfirmarExclusao');
    
    btnConfirmar.href = `excluir.php?id=${id}`;
    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Validação do CPF (somente números)
    document.getElementById('cpf').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    // Validação do formulário
    const form = document.getElementById('corretorForm');
    
    form.addEventListener('submit', function(event) {
        let isValid = true;
        
        // Resetar validações
        document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        
        // Validar CPF
        const cpf = document.getElementById('cpf');
        if (cpf.value.length !== 11 || !/^\d+$/.test(cpf.value)) {
            cpf.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validar Creci
        const creci = document.getElementById('creci');
        if (creci.value.length < 2) {
            creci.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validar Nome
        const nome = document.getElementById('nome');
        if (nome.value.length < 2) {
            nome.classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();
        }
    }, false);
});

// script.js
function confirmarExclusao(id) {
    if (confirm('Tem certeza que deseja excluir este corretor?')) {
        window.location.href = `excluir.php?id=${id}`;
    }
}