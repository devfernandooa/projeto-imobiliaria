<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CORREÇÃO 1: REMOVER LoginController e CENTRALIZAR em UsuarioController/HomeController ---
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UsuarioController; // Vamos usar este para a maioria das ações de Auth
use App\Http\Controllers\EnderecoController;
use App\Http\Controllers\ImobiliariaController;
use App\Http\Controllers\ImovelController;


/*
|--------------------------------------------------------------------------
| Rota Principal (Homepage)
|--------------------------------------------------------------------------
*/
// Rota Raiz: Sintaxe CORRIGIDA
Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Rotas de Autenticação (Login/Logout e Cadastro Público)
|--------------------------------------------------------------------------
*/
Route::group([], function () {

    // Rota GET /login: Redireciona para a página inicial
    Route::get('/login', function () {
        return redirect('/')->with('message', 'Você precisa estar logado para acessar o sistema.');
    })->name('login');

    // CORREÇÃO 2: Apontar Login/Logout/Register para o UsuarioController
    // Rota POST /login: Processa o login do formulário (do modal).
    Route::post('/login', [UsuarioController::class, 'authenticate'])->name('login.authenticate');

    // Rota POST /logout: Encerra a sessão do usuário.
    Route::post('/logout', [UsuarioController::class, 'logout'])->name('logout');

    // Rotas de Cadastro Público (Register)
    Route::get('/register', [UsuarioController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [UsuarioController::class, 'registerUser'])->name('register.store');
});

/*
|--------------------------------------------------------------------------
| Rotas Protegidas (Dashboards e CRUDs de Gestão)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ROTAS DE DASHBOARD POR PERFIL
    // Rota base de dashboard: Chama o UsuarioController para redirecionar
    Route::get('/dashboards', function () {
        // CORREÇÃO 3: Criamos uma instância do UsuarioController para chamar o método
        return (new UsuarioController())->redirecionamentoPorTipoUsuario(Auth::user());
    })->name('dashboard');

    // Rotas para painéis específicos (Protegidas pelo middleware 'can')
    // CORREÇÃO 4: Apontar para os métodos no UsuarioController
    Route::get('/dashboards/admin', [UsuarioController::class, 'showAdminDashboard'])->name('admin.dashboard')->middleware('can:access-admin-dashboard');
    Route::get('/dashboards/corretor', [UsuarioController::class, 'showCorretorDashboard'])->name('corretor.dashboard')->middleware('can:access-corretor-dashboard');
    Route::get('/dashboards/funcionario', [UsuarioController::class, 'showFuncionarioDashboard'])->name('funcionario.dashboard')->middleware('can:access-funcionario-dashboard');
    Route::get('/dashboards/cliente', [UsuarioController::class, 'showClienteDashboard'])->name('cliente.dashboard')->middleware('can:access-cliente-dashboard');


    // ------------------- GRUPO: CRUDs de Gestão -------------------

    // CRUD: Usuários
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
        Route::get('/criar', [UsuarioController::class, 'create'])->name('usuarios.create')->middleware('can:create-admin-users'); // Protegida
        Route::post('/', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/{usuario}', [UsuarioController::class, 'show'])->name('usuarios.show');
        Route::get('/{usuario}/editar', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/{usuario}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/{usuario}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');
    });

    // CRUD: Imóveis
    Route::prefix('imoveis')->group(function () {
        Route::get('/', [ImovelController::class, 'index'])->name('imoveis.index');
        Route::get('/criar', [ImovelController::class, 'create'])->name('imoveis.create');
        Route::post('/', [ImovelController::class, 'store'])->name('imoveis.store');
        Route::get('/{imovel}', [ImovelController::class, 'show'])->name('imoveis.show');
        Route::get('/{imovel}/editar', [ImovelController::class, 'edit'])->name('imoveis.edit');
        Route::put('/{imovel}', [ImovelController::class, 'update'])->name('imoveis.update');
        Route::delete('/{imovel}', [ImovelController::class, 'destroy'])->name('imoveis.destroy');
    });

    // CRUD: Imobiliárias
    Route::prefix('imobiliarias')->group(function () {
        Route::get('/', [ImobiliariaController::class, 'index'])->name('imobiliarias.index');
        Route::get('/criar', [ImobiliariaController::class, 'create'])->name('imobiliarias.create');
        Route::post('/', [ImobiliariaController::class, 'store'])->name('imobiliarias.store');
        // ... (Futuras rotas) ...
    });

    // CRUD: Endereços
    Route::prefix('enderecos')->group(function () {
        Route::get('/', [EnderecoController::class, 'index'])->name('enderecos.index');
        Route::get('/criar', [EnderecoController::class, 'create'])->name('enderecos.create');
        Route::post('/', [EnderecoController::class, 'store'])->name('enderecos.store');
        // ... (Futuras rotas) ...
    });
});