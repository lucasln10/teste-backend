document.addEventListener('DOMContentLoaded', function() {
    // Validação do CPF para aceitar apenas números
    document.getElementById('cpf').addEventListener('input', function() {
        this.value = this.value.replace(/\D/g, '');
    });

    // Validação do formulário no cliente
    document.getElementById('corretorForm').addEventListener('submit', function(event) {
        let isValid = true;
        
        // Resetar erros
        document.querySelectorAll('.error-message').forEach(el => el.style.display = 'none');
        document.querySelectorAll('input').forEach(el => el.classList.remove('error'));
        
        // Validar CPF
        const cpf = document.getElementById('cpf').value;
        if (cpf.length !== 11 || !/^\d+$/.test(cpf)) {
            document.getElementById('cpfError').style.display = 'block';
            document.getElementById('cpf').classList.add('error');
            isValid = false;
        }
        
        // Validar Creci
        const creci = document.getElementById('creci').value;
        if (creci.length < 2) {
            document.getElementById('creciError').style.display = 'block';
            document.getElementById('creci').classList.add('error');
            isValid = false;
        }
        
        // Validar Nome
        const nome = document.getElementById('nome').value;
        if (nome.length < 2) {
            document.getElementById('nomeError').style.display = 'block';
            document.getElementById('nome').classList.add('error');
            isValid = false;
        }
        
        if (!isValid) {
            event.preventDefault();
        }
    });
});