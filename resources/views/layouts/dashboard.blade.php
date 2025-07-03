<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Imobiliária Excelência</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    {{-- Uma diretiva para permitir que views filhas adicionem CSS específico --}}
    @stack('styles')
</head>
<body>
    {{-- Navbar Superior do Dashboard --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="main-navbar">
        <div class="container-fluid">
            {{-- Botão para expandir/recolher a sidebar --}}
            <button class="btn btn-outline-light me-3 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu">
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
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownUser" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->nome_completo }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdownUser">
                            <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                            <li><hr class="dropdown-divider"></li>
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
    <div class="offcanvas offcanvas-start bg-dark text-white sidebar-nav" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="sidebarMenuLabel">
                <i class="fas fa-cogs me-2"></i> Painel de Controle
            </h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body p-0">
            <nav class="navbar-dark">
                <ul class="navbar-nav">
                    <li>
                        {{-- Link para o dashboard geral --}}
                        <a href="{{ route('dashboard') }}" class="nav-link px-3 active">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                    </li>
                    <li class="my-2"><hr class="dropdown-divider bg-light"></li>
                    {{-- Links para Gerenciamento (Condicional por permissão) --}}
                    {{-- @can('access-admin-dashboard') --}}
                    <li>
                        <a href="{{ route('usuarios.index') }}" class="nav-link px-3">
                            <i class="fas fa-users me-2"></i> Gerenciar Usuários
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('imobiliarias.index') }}" class="nav-link px-3">
                            <i class="fas fa-building me-2"></i> Gerenciar Imobiliárias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('enderecos.index') }}" class="nav-link px-3">
                            <i class="fas fa-map-marker-alt me-2"></i> Gerenciar Endereços
                        </a>
                    </li>
                    {{-- @endcan --}}
                    <li>
                        <a href="#" class="nav-link px-3">
                            <i class="fas fa-home me-2"></i> Gerenciar Imóveis {{-- Será o próximo passo --}}
                        </a>
                    </li>
                    <li class="my-2"><hr class="dropdown-divider bg-light"></li>
                    <li>
                        <a href="#" class="nav-link px-3">
                            <i class="fas fa-chart-line me-2"></i> Relatórios
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    {{-- Conteúdo Principal do Dashboard --}}
    <main class="mt-5 pt-3">
        <div class="container-fluid">
            {{-- O CONTEÚDO ESPECÍFICO DE CADA DASHBOARD SERÁ INJETADO AQUI --}}
            @yield('content')
        </div>
    </main>

    {{-- Importa o Bootstrap JS (no final do body para melhor performance) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    {{-- Importa o JS customizado do dashboard --}}
    <script src="{{ asset('js/dashboard.js') }}"></script>
    {{-- Uma diretiva para permitir que views filhas adicionem JS específico --}}
    @stack('scripts')
</body>
</html>