<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa o Facde para autenticação
use Illuminate\Validation\ValidationException; // Para tratamento de erros de validação que podemos personalizar
use Illuminate\Support\Facades\Hash; // Importa o Facade para hash de senhas
use App\Models\Usuario; // Importa o model Usuario


class LoginController extends Controller
{
    /**
     * Exibe o formulário de login.
     * Esta rota será usada quando o Laravel redirecionar usuários não autenticados.
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Retorna a view de login
    }

    public function authenticate(Request $request)
    {
        $credenciais = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'O campo e-mail é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
            'password.required' => 'O campo senha é obrigatório.',
        ]);

        //Tenta autenticar o usuário
        //'senha' é o nome da coluna fornecida pelo banco de dados
        if (Auth::attempt(['email' => $credenciais['email'], 'password' => $credenciais['password']], $request->boolean('remember'))) {
            $request->session()->regenerate(); //Regenera a sessão para segunrança

            $usuario = Auth::user(); // Pega a instÂncia do usuário logado

            // Se logou com sucesso, redireciona a rota padrão de dashboard
            return redirect()->intended('/dashboards/admin');
        } else {
            //Se o login falhou, redireciona de volta com erro
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas não correspondem aos nossos registros.'],
            ]);
        }
    }

    /**
     * Redireciona o usuário para o dashboard apropriado com base no seu tipo e nível de acesso.
     * @param \App\Models\Usuario $usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirecionamentoPorTipoUsuario (Usuario $usuario) 
    {
        if ($usuario->nivel_acesso == 1 && $usuario->tipo_usuario == 'administrador') {
            return redirect()->route('admin.dashboard');
        } elseif ($usuario->nivel_acesso == 2 && $usuario->tipo_usuario == 'corretor') {
            return redirect()->route('corretor.dashboard');
        } elseif ($usuario->nivel_acesso == 3 && $usuario->tipo_usuario == 'funcionario') {
            return redirect()->route('funcionario.dashboard');
        } else {
            return redirect()->route('cliente.dashboard');
        }
    }

    /**
     * Faz o logout do usuário autenticado, invalida a sessão atual,
     * regenera o token CSRF e redireciona para a página inicial (index).
     *
     * @param  \Illuminate\Http\Request  $request  Instância da requisição HTTP atual.
     * @return \Illuminate\Http\RedirectResponse   Redireciona para a página inicial após o logout.
     */
    public function logout(Request $request)
    {
        Auth::logout(); //Faz o logout do usuário
        $request->session()->invalidate(); //Invalida a sessão atual
        $request->session()->regenerateToken(); //Gera um novo TOKEN CSRF
        return redirect('/');
    }
}
