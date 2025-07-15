<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Importa o Facde para autenticação
use Illuminate\Validation\ValidationException; // Para tratamento de erros de validação que podemos personalizar
use Illuminate\Support\Facades\Hash; // Importa o Facade para hash de senhas
use App\Models\Usuario; // Importa o model Usuario
use app\Models\Endereco;
use app\Models\Imobiliaria;


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

    /**
     * Exibe formulário de cadastro de usuário público (simplificado)
     * @return \Illuminate\View\View
     * 
     */
    public function showRegisterForm()
    {
        $enderecos = \App\Models\Endereco::all();
        return view('auth.register', compact('enderecos'));
    }

    /**
     * Trata o cadastro de um novo Usuário Público.
     * Define valores padões para campos sensiveis.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerUser(Request $request)
    {
        // Regras de validação para os CAMPOS QUE ESTÃO NO FORMULÁRIO PÚBLICO "QUASE COMPLETO"
        $userData = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:150',
            'senha' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|unique:usuarios,cpf|max:45',
            'data_nascimento' => 'nullable|date',
            'telefone1' => 'nullable|string|max:20', // Telefone1 agora é nullable (se não for requerido no DB)
            'telefone1_whatsapp' => 'boolean',
            'telefone2' => 'nullable|string|max:20',
            'telefone2_whatsapp' => 'boolean'
        ]);

        $userData = $request->except(['_token', 'senha_confirmation']);

        Usuario::create($userData);

        return redirect('/login')->with('success', 'Cadastro realizado com sucesso!');
    }

    public function authenticate(Request $request)
    {
        // 1. Validar os dados do formulário
        $userData = $request->validate([
            'email'    => 'required|email',
            'password' => 'required'
        ]);


        // 3. Tentar autenticar. Se falhar, lança a exceção e para a execução.
        if (!Auth::attempt($userData, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => 'As credenciais fornecidas não correspondem aos nossos registros.',
            ]);
        }

        // 4. Se a autenticação teve sucesso, o código continua aqui.
        // Regenera a sessão por segurança
        $request->session()->regenerate();

        // Redireciona para o dashboard
        return redirect()->intended('/dashboards/admin');
    }


    /**
     * Redireciona o usuário para o dashboard apropriado com base no seu tipo e nível de acesso.
     * @param \App\Models\Usuario $usuario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirecionamentoPorTipoUsuario(Usuario $usuario)
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
