<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\UsuarioController;
use app\Http\Controllers\EnderecoController;
use App\Http\Controllers\ImobiliariaController;


Route::get('/', function () {
    return view('index');
});


// -----------------// Rotas de autenticação \\-----------------
/**
 * Grupo de  Rotas de autenticação,  agrupamento simples sem prefixo URL, 
 * apenas para nittulo de organizar o código e a agrupar as rotas.
 */

 Route::group([], function () {
     Route::get('/login', function (){
        return redirect('/')->with('message', 'Você precisa estar logado para acessar o sistema.');
     })->name('login');
    //Rota para o processamento de login, o MODAL vai vir com o método POST sera direcionado para essa rota.
    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
    //Rota para o processamento de logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Rotas para cadastro público, essa rota vai exibiro formulário de cadastro público
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'registerUser'])->name('register.store');


 });


// Dashboard, grupo de Rotas que exigem autentcação
Route::middleware('auth')->group(function () {
    // Rota generica para o dashboard, vai ser redirecionando no controller LoginController
    Route::get('/dashboards', function () {
        return redirect()->action(LoginController::class, 'redirecionamentoPorTipoUsuario');
    })->name('dashboard');// Nome da rota principal que o LoginController chama
    /**
     * Route::middleware('auth'): Isso significa que todas as rotas dentro deste grupo só serão acessíveis se o usuário estiver logado.
     * Caso não esteja logado, o usuário será redirecionado para a página inicial para que efetue o login.
     * ->middleware('can:nome-da-permissao'): Isto é para o sistema de Gates e Policies do Laravel, que é a forma mais refinada de controlar permissões.
     * Neste caso, a rota só será acessível se o usuário tiver a permissão 'view-profile'.
    */     
    //Rotas para cada tipo de usuário
    Route::get('/dashboards/admin', function () {
        return view('dashboards.admin');
    })->name('admin.dashboard')->middleware('can:access-admin-dashboard');

    Route::get('/dashboards/corretor', function () {
        return view ('dasboards.corretor');
    })->name('corretor.dashboard')->middleware('can:access-corretor-dashboard');

    Route::get('/dashboards/funcionario', function () {
        return view ('dashboards.funcionario');
    })->name('funcionario.dashboard')->middleware('can:access-funcionario-dashboard');

    Route::get('/dashboards/cliente', function () {
        return view ('dashboards.cliente');
    })->name('cliente.dashboard')->middleware('can:access-cliente-dashboard');    

});


/**
 * Grupo de rotas para o CRUD de Endereços
 * Rotas para criar, editar, atualizar e excluir endereços
 */
Route::prefix('enderecos')->group(function () {
    // A Rota '/enderecos' agora vira '/' dentro do grupo 'enderecos'
    Route::get('/', [EnderecoController::class, 'index'])->name('enderecos.index');
    // A Rota '/enderecos/create' agora vira '/create' dentro do grupo
    Route::get('/criar', [EnderecoController::class, 'create'])->name('enderecos.create');
    // A Rota POST '/enderecos' agora vira '/' dentro do grupo
    Route::post('/', [EnderecoController::class, 'store'])->name('enderecos.store');
    // Podemos adicionar mais rotas aqui, como show, edit, update, destroy futuramente
    // Exemplo de rotas adicionais (comentadas para não interferir no funcionamento atual):
    // Route::get('/{id}', [EnderecoController::class, 'show'])->name('enderecos.show');
    // Route::get('/{id}/editar', [EnderecoController::class, 'edit'])->name('enderecos.edit');
    // Route::put('/{id}', [EnderecoController::class, 'update'])->name('enderecos.update');
    // Route::delete('/{id}', [EnderecoController::class, 'destroy'])->name('enderecos.destroy');
});


/**
 * Grupo de rotas para o CRUD de Usuários
 * Rotas para criar, editar, atualizar e excluir usuários
 */

Route::prefix('usuarios')->group(function () {
    //Rota para listar todos os Usuários, a Rota '/usuarios' agora vira '/' dentro do grupo 'usuarios'
    Route::get('/', [UsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/criar', [UsuarioController::class, 'create'])->name('usuarios.create');
    Route::post('/', [UsuarioController::class, 'store'])->name('usuarios.store');
});

/**
 * ROTAS DE CRUD PARA IMOBILIÁRIAS 
 * OBS: ImobiliariaController ainda não foi criado
 */
Route::prefix('imobiliarias')->group(function () {
    Route::get('/', [ImobiliariaController::class, 'index'])->name('imobiliarias.index'); // <-- CRÍTICO! Este nome.
    Route::get('/criar', [ImobiliariaController::class, 'create'])->name('imobiliarias.create');
    Route::post('/', [ImobiliariaController::class, 'store'])->name('imobiliarias.store');
    // Adicione aqui as rotas show, edit, update, destroy para Imobiliarias no futuro
});