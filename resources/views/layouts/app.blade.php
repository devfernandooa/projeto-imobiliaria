<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Imobiliária Imob Prime - Seu lar dos sonhos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/whatsappbtn.css') }}">
    @stack('styles')
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <i class="fas fa-home me-2"></i>Imob Prime 
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                {{-- LINKS DE NAVEGAÇÃO NORMAIS (Início, Imóveis, Corretores, etc.) --}}
                <ul class="navbar-nav"> 
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#properties">Imóveis</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#agents">Corretores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonials">Depoimentos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contato</a>
                    </li>
                </ul>

                {{-- Lógica condicional de login/logout/dashboard --}}
                {{-- Uma UL para os botões de autenticação, usando ms-auto --}}
                <ul class="navbar-nav ms-auto"> 
                    @auth {{-- Se o usuário estiver LOGADO --}}
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i> Bem-vindo, {{ Auth::user()->nome_completo }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                                <li><a class="dropdown-item" href="#">Meu Perfil</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Sair</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        {{-- Se o usuário NÃO estiver LOGADO --}}
                        <li class="nav-item">
                            <button class="btn btn-outline-primary nav-link me-2" data-bs-toggle="modal"
                                data-bs-target="#loginModal">Login</button>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary nav-link" href="{{ route('register') }}"
                                style="color: white;">Cadastre-se</a>
                        </li>
                    @endauth
                </ul> {{-- <--- FIM DA UL --}}
            </div>
        </div>
    </nav>

    {{-- ... (restante do código: main, footer, modal, scripts) ... --}}
    <main>
        @yield('content')
    </main>

    @include('layouts.footer')

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Acesse sua conta</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger mb-3">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form id="loginForm" action="{{ route('login.authenticate') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="loginEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="loginEmail" name="email"
                                value="{{ old('email') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="loginPassword" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="rememberMe" name="remember">
                            <label class="form-check-label" for="rememberMe">Lembrar de mim</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                    <div class="text-center mt-3">
                        <a href="#" class="text-decoration-none">Esqueceu sua senha?</a>
                    </div>
                    <hr>
                    <div class="text-center">
                        <p class="mb-0">Não tem uma conta? <a href="{{ route('usuarios.create') }}"
                                class="text-primary" data-bs-toggle="modal" data-bs-target="#registerModal"
                                data-bs-dismiss="modal">Cadastre-se</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
