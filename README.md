# Documentação do Sistema de Cadastro de Corretores

## 📝 Visão Geral
Sistema completo para cadastro de corretores imobiliários com persistência em banco de dados MySQL, desenvolvido em PHP com interface Bootstrap 5. Inclui funcionalidades CRUD (Create, Read, Update, Delete) com validações robustas.

## ✨ Funcionalidades
- **Cadastro de corretores** com CPF, CRECI e Nome
- **Validação em tempo real** dos campos
- **Edição e exclusão** de registros
- **Visualização em tabela** com formatação automática
- **Feedback visual** para todas as operações
- **Responsivo** para mobile e desktop

## 🛠️ Pré-requisitos
- Servidor web (Laragon/XAMPP/WAMP)
- PHP 7.4+
- MySQL 5.7+
- Navegador moderno

## 🚀 Instalação
1. Clone o repositório:
```bash
git clone https://github.com/seu-usuario/cadastro-corretores.git
```

2. Configure o banco de dados:
```sql
CREATE DATABASE imobiliaria;
USE imobiliaria;

CREATE TABLE corretores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cpf VARCHAR(11) NOT NULL,
    creci VARCHAR(20) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3. Configure a conexão em `conexao.php`:
```php
<?php
$host = 'localhost';
$dbname = 'imobiliaria';
$username = 'root';
$password = '';

// ... código de conexão
?>
```

## 🏗️ Estrutura de Arquivos
```
📦 cadastro-corretores
|
│── 📜 style.css        # Estilos customizados
│── 📜 script.js        # Validações e interações
├── 📜 index.php            # Página principal
├── 📜 cadastrar.php        # Processa novos cadastros
├── 📜 editar.php           # Processa edições
├── 📜 excluir.php          # Processa exclusões
├── 📜 conexao.php          # Configuração do banco
└── 📜 README.md            # Esta documentação
```

## 🔄 Fluxo de Trabalho
1. **Cadastro**:
   - Preencha CPF (11 dígitos), CRECI (2+ caracteres) e Nome (2+ caracteres)
   - Validações impedem envio de dados inválidos

2. **Edição**:
   - Clique em "Editar" na tabela
   - O formulário é preenchido automaticamente
   - Botão muda para "Salvar"

3. **Exclusão**:
   - Clique em "Excluir" na tabela
   - Confirmação modal é exibida
   - Registro é removido após confirmação

## ✅ Validações Implementadas
| Campo   | Regras                          | Cliente | Servidor |
|---------|---------------------------------|---------|----------|
| CPF     | 11 dígitos, apenas números      | ✔️      | ✔️       |
| CRECI   | Mínimo 2 caracteres             | ✔️      | ✔️       |
| Nome    | Mínimo 2 caracteres             | ✔️      | ✔️       |

## 📱 Responsividade
O sistema se adapta a diferentes tamanhos de tela:
- **Desktop**: Tabela completa com todas as colunas
- **Mobile**: Scroll horizontal na tabela e botões adaptados

## 🛡️ Segurança
- Prepared statements contra SQL Injection
- htmlspecialchars() contra XSS
- Validação redundante (cliente + servidor)
- Mensagens de erro genéricas (não expõe detalhes)


