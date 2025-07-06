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
        return view('auth.register', $enderecos);
    }

    /**
     * Trata o cadastro de um novo Usuário Público.
     * Define valores padões para campos sensiveis.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registerUser(Request $request)
    {
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:150',
            'senha' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|unique:usuarios,cpf|max:45',
        ], [
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
            'senha.confirmed' => 'A confirmação de senha não corresponde.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
        ]);

        $userData = $request->except(['_token', 'senha_confirmacao']);
        // ATRIBUIÇÃO MANUAL DE PADRÕES PARA CADASTRO PÚBLICO (CLIENTE)
        $userData['tipo_usuario'] = 'cliente';
        $userData['nivel_acesso'] = 4; // Nível para clientes
        $userData['ativo'] = true; // Ativo por padrão
        $userData['receber_email'] = true; // Receber emails por padrão
        $userData['receber_sms'] = false; // Não receber SMS por padrão
        $userData['receber_whatsapp'] = false; // Não receber WhatsApp por padrão

        // Definir null para campos que não vêm do formulário público
        $userData['telefone1'] = $request->input('telefone1', null);
        $userData['telefone1_whatsapp'] = $request->has('telefone1_whatsapp');
        $userData['telefone2'] = $request->input('telefone2', null);
        $userData['telefone2_whatsapp'] = $request->has('telefone2_whatsapp');
        $userData['endereco_id'] = $request->input('endereco_id', null); // Se for permitido no cadastro público
        $userData['rg'] = $request->input('rg', null);
        $userData['orgao_emissor'] = $request->input('orgao_emissor', null);
        $userData['data_nascimento'] = $request->input('data_nascimento', null);
        $userData['estado_civil'] = $request->input('estado_civil', null);
        $userData['profissao'] = $request->input('profissao', null);
        $userData['empresa'] = $request->input('empresa', null);
        $userData['cargo'] = $request->input('cargo', null);
        $userData['salario'] = $request->input('salario', null);
        $userData['cep'] = $request->input('cep', null);
        $userData['creci'] = null;
        $userData['foto_url'] = null;
        $userData['matricula'] = null;
        $userData['instagram'] = null;
        $userData['facebook'] = null;
        $userData['twitter'] = null;
        $userData['linkedin'] = null;
        $userData['imobiliaria_id'] = null;

        Usuario::create($userData);
        return redirect('/login')->with('success', 'Cadastro realizado com sucesso!');
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
