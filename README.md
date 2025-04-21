# CRM System - CodeIgniter 4

Sistema CRM com dois níveis de usuário: Administrador e Usuário normal.

## Requisitos

- PHP 7.4+
- MySQL 5.7+
- Composer
- CodeIgniter 4.x

## Instalação

1. Clone o repositório ou descompacte os arquivos no diretório do projeto

2. Configure o ambiente:
   ```bash
   cp env .env
   ```

3. Edite o arquivo `.env` e configure a conexão com o banco de dados:
   ```
   database.default.hostname = localhost
   database.default.database = crm_database
   database.default.username = root
   database.default.password = 
   database.default.DBDriver = MySQLi
   ```

4. Instale as dependências do Composer:
   ```bash
   composer install
   ```

5. Crie o banco de dados:
   ```sql
   CREATE DATABASE crm_database;
   ```

6. Execute as migrations:
   ```bash
   php spark migrate
   ```

7. Execute o seeder para criar o usuário administrador:
   ```bash
   php spark db:seed AdminSeeder
   ```

## Uso

### Acesso inicial

- URL: http://localhost/crm/public/
- Email: admin@crm.com
- Senha: admin123

### Funcionalidades do Administrador

- Gerenciar usuários (criar, editar, excluir)
- Gerenciar pipelines (criar, editar, excluir, atribuir)
- Visualizar todos os leads de todos os usuários
- Exportar leads em CSV

### Funcionalidades do Usuário

- Gerenciar seus próprios leads (criar, editar, excluir)
- Visualizar seus pipelines atribuídos
- Mover leads entre estágios (drag-and-drop)
- Exportar seus leads em CSV

## Estrutura do Projeto

```
app/
├── Config/          # Configurações do aplicativo
├── Controllers/     # Controladores
│   ├── Admin/      # Controladores do administrador
│   ├── Api/        # Controladores da API
│   └── User/       # Controladores do usuário
├── Database/        # Migrations e Seeds
├── Filters/         # Filtros de autenticação
├── Models/          # Modelos
└── Views/           # Views
    ├── admin/      # Views do administrador
    ├── auth/       # Views de autenticação
    ├── layouts/    # Layouts base
    └── user/       # Views do usuário
```

## Segurança

- Todos os endpoints são protegidos por autenticação
- Endpoints do administrador verificam o nível de acesso
- Senhas são armazenadas com hash seguro
- Proteção contra CSRF habilitada