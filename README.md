
Sistema de Gestão Imobiliária

<p align="center">
<img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP" />
<img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel" />
<img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL" />
<img src="https://img.shields.io/badge/Composer-885630?style=for-the-badge&logo=composer&logoColor=white" alt="Composer" />
<img src="https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white" alt="HTML5" />
<img src="https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white" alt="CSS3" />
<img src="https://img.shields.io/badge/JavaScript-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
<img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap" />
<img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" alt="Docker" />
</p>

Este projeto é um sistema web em desenvolvimento para gestão de imóveis, imobiliárias e usuários, construído com o framework Laravel. Ele utiliza a virtualização via Docker Compose para garantir um ambiente de trabalho estável e portátil.

🚀 Tecnologias Utilizadas

    Ambiente: Docker Compose (PHP-FPM, Nginx, MySQL 8.0)

    Backend: PHP 8.3+ com Laravel Framework 12.x

    Banco de Dados: MySQL

    Frontend: HTML5, CSS3, JavaScript (com Bootstrap 5.3)

🐳 Instalação e Configuração (Ambiente Docker)

Para subir a aplicação, utilize o Docker Compose. O ambiente será construído com todas as dependências necessárias.

    Configurar Arquivo de Ambiente (.env):

        Renomeie o arquivo .env.example para .env.

        Defina as credenciais do banco de dados para o ambiente Docker. É crucial usar db como host.
        Snippet de código

    DB_CONNECTION=mysql
    DB_HOST=db                 # CRÍTICO: Nome do serviço MySQL no docker-compose.yml
    DB_PORT=3306
    DB_DATABASE=gestao_imobiliaria_db
    DB_USERNAME=imob_user      # Usuário não-root para a conexão da aplicação
    DB_PASSWORD=sua_senha_forte 

    CACHE_DRIVER=file          # Cache em arquivo, para não depender do DB na inicialização
    APP_URL=http://localhost

Construir Imagens e Subir os Contêineres:

    Execute na raiz do projeto:
    Bash

    docker-compose up -d --build

Instalar Dependências e Migrar o Banco (Comandos no Contêiner):

    Todos os comandos php artisan e composer devem ser executados via docker-compose exec app.
    Bash

        # 1. Instalar dependências PHP
        docker-compose exec app composer install

        # 2. Criar tabelas e popular dados de teste
        docker-compose exec app php artisan migrate:fresh --seed

    Acessar a Aplicação:

        Acesse http://localhost no seu navegador.

        Usuário Admin de Teste (Criado via Seeder):

            Email: admin@imobprime.com

            Senha: senha123

✨ Funcionalidades Implementadas

    Gestão de Usuários (CRUD COMPLETO):

        Criação: Cadastro público simplificado (/register) e formulário completo para Admin (com todos os campos).

        Visualização: Listagem com tabela Bootstrap e tela de detalhes (usuarios.show).

        Edição: Formulário de edição (usuarios.edit) com pré-preenchimento e lógica de atualização de dados (usuarios.update).

        Exclusão: Exclusão segura via modal de confirmação (sem JavaScript).

    Autenticação e Permissões (Segurança):

        Login/Logout e Redirecionamento para dashboards específicos (/admin/dashboard, /cliente/dashboard).

        Lógica de Nível Forçado: O nivel_acesso é automaticamente definido no backend (Admin=1, Corretor=2, Cliente=4), garantindo consistência, mesmo que o Admin o selecione no formulário.

        Configuração Avançada: Uso de getAuthPasswordName() e protected $casts = ['senha' => 'hashed'] para segurança máxima na coluna senha.

        Autorização: Gates (@can) definidos para proteger rotas de dashboard.

    Layout & Usabilidade:

        Layouts base (app.blade.php, dashboard.blade.php) com menu lateral dinâmico que se adapta ao tipo de usuário.

        Mensagens de validação em Português do Brasil (pt_BR).

        Botão flutuante de WhatsApp na página inicial.

💡 Principais Abordagens e Decisões de Design

    Virtualização: Uso de Docker para ambiente de desenvolvimento portátil.

    Segurança de Senha: Hashing automático e mapeamento de coluna de senha customizada (senha).

    Design de Permissões: Definição de níveis de acesso fixos e Gates para controle rigoroso de acesso.

    Separação de Preenchimento: Lógica JavaScript para autopreenchimento de campos do formulário (nível de acesso) para simplificar a UX.

🗺️ Próximos Passos (Roadmap)

    CRUD Completo para Imóveis (Foco principal).

    Upload de Fotos de Imóveis.

    CRUD Completo para Imobiliárias e Endereços (finalização).

🤝 Autores:

Autor	LinkedIn
Fernando Almeida	https://www.linkedin.com/in/fernandooar/
Weslei Cardoso	https://www.linkedin.com/in/wesleicardoso/
