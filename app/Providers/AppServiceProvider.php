<?php

namespace App\Providers;



use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Usuario;

class AppServiceProvider extends ServiceProvider
{

    protected $polices = [
        //
    ];
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-admin-dashboard', function(Usuario $usuario){
            return $usuario->nivel_acesso === 1 && $usuario->tipo_usuario === 'administrador';
        });

        Gate::define('access-corretor-dashboard', function(Usuario $usuario){
            return $usuario->nivel_acesso === 2 && $usuario->tipo_usuario === 'corretor';
        });      
        
        Gate::define('access-funcionario-dashboard', function(Usuario $usuario){
            return $usuario->nivel_acesso === 3 && $usuario->tipo_usuario === 'funcionario';
        });

        Gate::define('access-cliente-dashboard', function(Usuario $usuario){
            return $usuario->nivel_acesso === 4 && in_array($usuario->tipo_usuario, ['cliente', 'proprietario', 'locatario']);
        });

        // Gate "catch-all" para acesso geral ao dashboard (pode ser útil)
        // Se um usuário tentar acessar um dashboard específico sem permissão,
        // ele pode ser redirecionado para seu próprio dashboard padrão.
        Gate::define('access-any-dashboard', function (Usuario $usuario){
            return $usuario->nivel_acesso >= 1 && $usuario->nivel_acesso <= 4; // Qualquer nível válido 
        });
    }
}
