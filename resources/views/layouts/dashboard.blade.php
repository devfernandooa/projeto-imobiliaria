<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Imobiliária Imob Prime</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- Uma diretiva para permitir que views filhas adicionem CSS específico --}}
    @stack('styles')
</head>

<body>
    {{-- Navbar Superior do Dashboard --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top px-3" id="main-navbar">
        <div class="container-fluid ">
            {{-- Botão para expandir/recolher a sidebar --}}
            <button class="btn btn-outline-light me-3 d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
                <i class="fas fa-bars"></i>
            </button>
            {{-- Nome da Imobiliária (obtido do usuário logado) --}}
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-building me-2"></i>
                {{ Auth::user()->imobiliaria->nome_fantasia ?? 'Minha Imobiliária' }} {{-- Exibe o nome da Imobiliária do usuário logado --}}
            </a>

            <div class="collapse navbar-collapse" id="navbarNavDashboard">
                <ul class="navbar-nav ms-auto">
                    {{-- Exibe o nome do usuário logado --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->nome_completo }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end"
                            aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                {{-- Formulário para logout --}}
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf {{-- Diretiva Blade para proteção CSRF --}}
                                    <button type="submit" class="dropdown-item">Sair</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Sidebar (Menu Lateral) --}}
    {{-- ... (código anterior do layout/dashboard.blade.php) ... --}}

    {{-- Sidebar (Menu Lateral) --}}
    <div class=" offcanvas-start bg-dark text-white sidebar-nav" tabindex="-1" id="sidebarMenu"
        aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                <i class="fas fa-cogs me-2"></i> Painel de Controle
            </h5>
            <button type="button" class="btn-close text-reset d-lg-none" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>
        {{-- Em resources/views/layouts/dashboard.blade.php --}}

        {{-- ... (código anterior da sidebar) ... --}}

        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    {{-- Item de menu: Dashboard Geral (sempre visível) --}}
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link px-3 active">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="my-2">
                        <hr class="dropdown-divider bg-light">
                    </li>

                    {{-- BLOCO PARA FUNCIONALIDADES DE ADMIN/CORRETOR/FUNCIONÁRIO --}}
                    @canany(['access-admin-dashboard', 'access-corretor-dashboard', 'access-funcionario-dashboard'])
                        {{-- SUB-MENU: Gerenciar Usuários --}}
                        <li>
                            <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#usuariosCollapse"
                                role="button" aria-expanded="false" aria-controls="usuariosCollapse">
                                <i class="fas fa-users me-2"></i> Gerenciar Usuários
                                <span class="right-icon ms-auto"><i class="fas fa-chevron-down"></i></span>
                            </a>
                            <div class="collapse" id="usuariosCollapse">
                                <ul class="navbar-nav ps-3">
                                    <li>
                                        <a href="{{ route('usuarios.index') }}" class="nav-link px-3">
                                            <i class="fas fa-list me-2"></i> Listar Usuários
                                        </a>
                                    </li>
                                    @can('create-admin-users')
                                        <li>
                                            <a href="{{ route('usuarios.create') }}" class="nav-link px-3">
                                                <i class="fas fa-user-plus me-2"></i> Criar Usuário
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </li>

                        {{-- SUB-MENU: Gerenciar Imobiliárias (apenas administradores) --}}
                        @can('access-admin-dashboard')
                            <li>
                                <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#imobiliariasCollapse"
                                    role="button" aria-expanded="false" aria-controls="imobiliariasCollapse">
                                    <i class="fas fa-building me-2"></i> Gerenciar Imobiliárias
                                    <span class="right-icon ms-auto"><i class="fas fa-chevron-down"></i></span>
                                </a>
                                <div class="collapse" id="imobiliariasCollapse">
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="{{ route('imobiliarias.index') }}" class="nav-link px-3">
                                                <i class="fas fa-list me-2"></i> Listar Imobiliárias
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('imobiliarias.create') }}" class="nav-link px-3">
                                                <i class="fas fa-plus me-2"></i> Criar Imobiliária
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan

                        {{-- SUB-MENU: Gerenciar Endereços (apenas administradores) 
                        @can('access-admin-dashboard')
                            <li>
                                <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#enderecosCollapse"
                                    role="button" aria-expanded="false" aria-controls="enderecosCollapse">
                                    <i class="fas fa-map-marker-alt me-2"></i> Gerenciar Endereços
                                    <span class="right-icon ms-auto"><i class="fas fa-chevron-down"></i></span>
                                </a>
                                <div class="collapse" id="enderecosCollapse">
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="{{ route('enderecos.index') }}" class="nav-link px-3">
                                                <i class="fas fa-list me-2"></i> Listar Endereços
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('enderecos.create') }}" class="nav-link px-3">
                                                <i class="fas fa-plus me-2"></i> Criar Endereço
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcan--}}

                        {{-- SUB-MENU: Gerenciar Imóveis (Admin e Corretor) --}}
                        @canany(['access-admin-dashboard', 'access-corretor-dashboard'])
                            <li>
                                <a class="nav-link px-3 sidebar-link" data-bs-toggle="collapse" href="#imoveisCollapse"
                                    role="button" aria-expanded="false" aria-controls="imoveisCollapse">
                                    <i class="fas fa-home me-2"></i> Gerenciar Imóveis
                                    <span class="right-icon ms-auto"><i class="fas fa-chevron-down"></i></span>
                                </a>
                                <div class="collapse" id="imoveisCollapse">
                                    <ul class="navbar-nav ps-3">
                                        <li>
                                            <a href="#" class="nav-link px-3">
                                                <i class="fas fa-list me-2"></i> Listar Imóveis
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" class="nav-link px-3">
                                                <i class="fas fa-plus me-2"></i> Criar Imóvel
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        @endcanany

                        <li class="my-2">
                            <hr class="dropdown-divider bg-light">
                        </li>

                        {{-- Item de menu: Relatórios (apenas administradores) --}}
                        @can('access-admin-dashboard')
                            <li>
                                <a href="#" class="nav-link px-3">
                                    <i class="fas fa-chart-line me-2"></i> Relatórios
                                </a>
                            </li>
                        @endcan
                    @else
                        {{-- BLOCO PARA USUÁRIOS BÁSICOS (CLIENTES, PROPRIETÁRIOS, LOCATÁRIOS) --}}
                        {{-- ITENS DE MENU ESPECÍFICOS PARA CLIENTES, PROPRIETÁRIOS, LOCATÁRIOS --}}
                        <li>
                            <a href="{{ route('cliente.dashboard') }}" class="nav-link px-3">
                                <i class="fas fa-user-circle me-2"></i> Meu Perfil
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-3">
                                <i class="fas fa-building me-2"></i> Meus Imóveis
                            </a>
                        </li>
                        <li>
                            <a href="#" class="nav-link px-3">
                                <i class="fas fa-file-invoice-dollar me-2"></i> Meus Contratos
                            </a>
                        </li>
                    @endcanany {{-- Fecha o @canany inicial --}}
                </ul>
            </nav>
        </div>

    </div> {{-- Fechamento do Sidebar (Menu Lateral) --}}
</div>

    {{-- ... (restante do código do layout/dashboard.blade.php) ... --}}
    <main class="container mt-6 pt-3">
        <div class="container align-items-start">

            {{-- Título do Dashboard --}}
            {{-- O CONTEÚDO ESPECÍFICO DE CADA DASHBOARD SERÁ INJETADO AQUI --}}
            @yield('content')
        </div>
    </main>

    {{-- Conteúdo Principal do Dashboard --}}

    {{-- Importa o Bootstrap JS (no final do body para melhor performance) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Importa o JS customizado do dashboard --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
    {{-- Uma diretiva para permitir que views filhas adicionem JS específico --}}
    @stack('scripts')
</body>

</html>
