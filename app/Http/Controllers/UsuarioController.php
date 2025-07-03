<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Imobiliaria;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{

    /**
     * Exibe uma lista de usuários juntamente com seus endereços e imobiliárias.
     *
     * Recupera todos os usuários do banco de dados, incluindo seus endereços ('enderecos')
     * e imobiliárias ('imobiliarias'), e passa para a view 'usuarios.index'.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuarios = Usuario::with(['endereco', 'imobiliaria'])->get();
        return view('usuarios.index', compact('usuarios'));
    }


    /**
     * Exibe o formulário de criação de usuário.
     *
     * Busca todos os endereços e imobiliárias existentes para popular os campos de seleção (dropdowns)
     * no formulário de criação de usuário. Em seguida, retorna a view 'usuarios.create' passando as listas
     * de endereços e imobiliárias como variáveis.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        /**
         * Para os campos de seleção (dropdowns) de Endereços e Imobiliarias,
         * precisa buscar todos os endereços e imobiliarias existentes para popular as opções
         */
        $enderecos = Endereco::all();
        $imobiliarias = Imobiliaria::all();
        //Passa a lista para a view do formulário
        return view('usuarios.create', compact('enderecos', 'imobiliarias'));
    }

    /**
     * Armazena um novo usuário no banco de dados.
     *
     * Valida os dados recebidos da requisição para criar um novo usuário, garantindo que todos os campos obrigatórios
     * estejam presentes e corretamente formatados. Mensagens de validação personalizadas são fornecidas para maior clareza.
     *
     * As regras de validação incluem:
     * - Campos obrigatórios: nome_completo, email, senha, cpf, tipo_usuario, nivel_acesso
     * - Restrições de unicidade: email, cpf, creci, matricula
     * - Verificações de formato e tamanho para strings, emails, datas e URLs
     * - Verificações booleanas para diversos flags (telefone1_whatsapp, telefone2_whatsapp, ativo, receber_email, receber_sms, receber_whatsapp)
     * - Verificação de existência para entidades relacionadas (endereco_id, imobiliaria_id)
     * - Validação ENUM para tipo_usuario
     * - Campos opcionais (nullable) para informações adicionais do usuário
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Regras de validação para os campos que estão NO FORMULÁRIO PÚBLICO
        $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:150',
            'senha' => 'required|string|min:8|confirmed',
            'telefone1' => 'nullable|string|max:20',
            'telefone1_whatsapp' => 'boolean',
            'telefone2' => 'nullable|string|max:20',
            'telefone2_whatsapp' => 'boolean',
            'endereco_id' => 'nullable|exists:enderecos,id', // Endereco pode ser null no BD
            'cpf' => 'required|string|unique:usuarios,cpf|max:45',
            'rg' => 'nullable|string|max:45',
            'orgao_emissor' => 'nullable|string|max:45',
            'data_nascimento' => 'nullable|date',
            'estado_civil' => 'nullable|string|max:20',
            'profissao' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:100',
            'cargo' => 'nullable|string|max:100', // Campo existe no DB, mas não no form. Se não setado, DB default será usado.
            'salario' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:10',
            // 'creci' => 'nullable|string|unique:usuarios,creci|max:50', // Removido do form
            // 'foto_url' => 'nullable|url|max:255', // Removido do form
            // 'matricula' => 'nullable|string|unique:usuarios,matricula|max:50', // Removido do form
            // 'tipo_usuario' => 'required|in:administrador,corretor,cliente,proprietario,locatario,funcionario', // Removido do form
            // 'nivel_acesso' => 'required|integer', // Removido do form
            // 'ativo' => 'boolean', // Removido do form
            // 'receber_email' => 'boolean', // Removido do form
            // 'receber_sms' => 'boolean', // Removido do form
            // 'receber_whatsapp' => 'boolean', // Removido do form
            // Redes sociais também removidas do form
            // 'imobiliaria_id' => 'nullable|exists:imobiliarias,id', // Removido do form
        ], [
            // Mensagens de validação personalizadas
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

        $userData = $request->except(['_token', 'senha_confirmation']);

        // Tratamento dos checkboxes de telefone
        $userData['telefone1_whatsapp'] = $request->has('telefone1_whatsapp');
        $userData['telefone2_whatsapp'] = $request->has('telefone2_whatsapp');

        // ATRIBUIÇÃO MANUAL DOS PADRÕES PARA CADASTRO PÚBLICO
        // Estes campos estão no $guarded e/ou não vêm do formulário, então os definimos aqui.
        $userData['tipo_usuario'] = 'cliente'; // Padrão para cadastro público
        $userData['nivel_acesso'] = 4;        // Nível 4 para cliente
        $userData['ativo'] = true;            // Usuário ativo por padrão ao se cadastrar
        $userData['receber_email'] = true;    // Receber emails por padrão
        $userData['receber_sms'] = false;     // Não receber SMS por padrão
        $userData['receber_whatsapp'] = false; // Não receber WhatsApp por padrão

        // Campos que não estão no formulário mas podem ter default no DB ou serem null
        // 'creci', 'foto_url', 'matricula', redes sociais
        // Se eles não estiverem no $userData, e a coluna for nullable, o Laravel salva NULL.
        // Se a coluna tiver um default no DB e não for nullable, o DB usa o default.
        // Se a coluna for NOT NULL e sem default e você não passar, dará erro.
        // Para 'cargo', que você tinha no form e removi, mas está no DB:
        $userData['cargo'] = $request->input('cargo', null); // Garante que é null se não veio do form
        $userData['salario'] = $request->input('salario', null);
        $userData['empresa'] = $request->input('empresa', null);
        $userData['profissao'] = $request->input('profissao', null);
        $userData['estado_civil'] = $request->input('estado_civil', null);
        $userData['orgao_emissor'] = $request->input('orgao_emissor', null);
        $userData['data_nascimento'] = $request->input('data_nascimento', null);
        $userData['cep'] = $request->input('cep', null);
        $userData['creci'] = null; // Definido como null para novos cadastros públicos
        $userData['foto_url'] = null;
        $userData['matricula'] = null;
        $userData['instagram'] = null;
        $userData['facebook'] = null;
        $userData['twitter'] = null;
        $userData['linkedin'] = null;
        $userData['imobiliaria_id'] = null; // Clientes não se associam a imobiliária no cadastro público

        // Cria o usuário. O hashing da senha é feito automaticamente pelo cast 'hashed' na Model!
        Usuario::create($userData);

        return redirect('/login')->with('success', 'Cadastro realizado com sucesso! Por favor, faça login.');
    }
}


    

