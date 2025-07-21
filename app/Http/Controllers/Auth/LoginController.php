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
     * Redireciona o usuário para o dashboard apropriado com base no seu tipo e nível de acesso.
     * @param \App\Models\Usuario $usuario
     * @return \Illuminate\Http\RedirectResponse
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
        return view('auth.register');
    }

    /**
     * Trata o cadastro de um novo usuário a partir do formulário público minimalista.
     *
     * Este método executa as seguintes ações:
     * 1. Valida os dados essenciais do formulário de registro público (nome, e-mail, senha, CPF, telefone).
     * 2. Prepara os dados para a criação, tratando campos booleanos como 'telefone1_whatsapp'.
     * 3. Atribui valores padrão para um novo usuário do tipo 'cliente', incluindo nível de acesso e preferências de comunicação.
     * 4. Define explicitamente como nulos os campos que não fazem parte do formulário público.
     * 5. Cria o novo registro de usuário no banco de dados.
     * 6. Autentica (loga) o usuário recém-criado na aplicação.
     * 7. Redireciona o usuário para o seu painel de controle ('cliente.dashboard') com uma mensagem de sucesso.
     *
     * @param  \Illuminate\Http\Request  $request A requisição HTTP contendo os dados do formulário.
     * @return \Illuminate\Http\RedirectResponse Um redirecionamento para o painel do cliente.
     * @throws \Illuminate\Validation\ValidationException Lançada se a validação dos dados da requisição falhar.
     */
    public function registerUser(Request $request)
    {
        // Regras de validação para os CAMPOS QUE ESTÃO NO FORMULÁRIO PÚBLICO MINIMALISTA
        $validatedData = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:150',
            'senha' => 'required|string|min:8|confirmed',
            'cpf' => 'required|string|unique:usuarios,cpf|max:45',
            'telefone1' => 'required|string|max:20', // Telefone 1 agora é obrigatório (para contato mínimo)
            'telefone1_whatsapp' => 'boolean',
            // RG, Data de Nascimento, Telefone 2, Endereço e todos os outros campos foram removidos.
        ], [
            // Mensagens de validação personalizadas para USUÁRIO
            'nome_completo.required' => 'O nome completo é obrigatório.',
            'email.required' => 'O email é obrigatório.',
            'email.email' => 'Por favor, insira um endereço de email válido.',
            'email.unique' => 'Este email já está cadastrado.',
            'senha.required' => 'A senha é obrigatória.',
            'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
            'senha.confirmed' => 'A confirmação de senha não corresponde.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já está cadastrado.',
            'telefone1.required' => 'O telefone 1 é obrigatório.',
        ]);

        
        // Agora o usuário pode ser criado sem um endereco_id inicial, será null no DB.

        $userData = $validatedData; // Começa com os dados JÁ VALIDADOS.

        // TRATAMENTO DOS CHECKBOXES BOOLEANOS
        $userData['telefone1_whatsapp'] = $request->has('telefone1_whatsapp');
        // 'telefone2_whatsapp' foi removido do form, então não precisa tratar aqui.

        // ATRIBUIÇÃO MANUAL DE PADRÕES PARA CADASTRO PÚBLICO (CLIENTE/PROPRIETÁRIO/LOCATÁRIO)
        $userData['tipo_usuario'] = 'cliente';
        $userData['nivel_acesso'] = 4;
        $userData['ativo'] = true;
        $userData['receber_email'] = true;
        $userData['receber_sms'] = false;
        $userData['receber_whatsapp'] = false;

        // Definir NULL para CAMPOS QUE FORAM REMOVIDOS DO FORMULÁRIO PÚBLICO E NÃO SÃO TRATADOS
        $userData['rg'] = null;
        $userData['orgao_emissor'] = null;
        $userData['data_nascimento'] = null;
        $userData['estado_civil'] = null;
        $userData['profissao'] = null;
        $userData['empresa'] = null;
        $userData['cargo'] = null;
        $userData['salario'] = null;
        $userData['cep'] = null; // O CEP do usuário não vem mais do form público
        $userData['creci'] = null;
        $userData['foto_url'] = null;
        $userData['matricula'] = null;
        $userData['instagram'] = null;
        $userData['facebook'] = null;
        $userData['twitter'] = null;
        $userData['linkedin'] = null;
        $userData['imobiliaria_id'] = null;

        // Vinculação de Endereço (agora null, pois não é criado neste fluxo)
        $userData['endereco_id'] = null; // <--- Endereco_id agora é null

        $novoUsuario = Usuario::create($userData); // Cria o usuário

        // LOGAR O USUÁRIO AUTOMATICAMENTE APÓS O CADASTRO E REDIRECIONAR
        Auth::login($novoUsuario);

        return redirect()->route('cliente.dashboard')->with('success', 'Cadastro realizado com sucesso! Bem-vindo!');
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


        // 5. Dados do usuario autenticado
        $userLogin = Auth::user();

        // Redireciona para o dashboard
        return $this->redirect($userLogin);
    }



    public function redirect(Usuario $usuario)
    {
        if ($usuario->nivel_acesso == 1 && $usuario->tipo_usuario == 'administrador') {
            return redirect()->route('admin.dashboard');
        } else if ($usuario->nivel_acesso == 2 && $usuario->tipo_usuario == 'corretor') {
            return redirect()->route('corretor.dashboard');
        } else if ($usuario->nivel_acesso == 3 && $usuario->tipo_usuario == 'funcionario') {
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
