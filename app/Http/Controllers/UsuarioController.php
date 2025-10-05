<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Imobiliaria;
use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Exibe uma listagem dos usuários.
     *
     * Recupera todos os usuários com suas informações de endereço e imobiliária associadas.
     * Passa os dados para a view 'usuarios.index' para exibição.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $usuarios = \App\Models\Usuario::with(['endereco', 'imobiliaria'])->get();

        return view('usuarios.index', compact('usuarios'));
    }

    /**
     * Exibe uma listagem dos usuários.
     *
     * Recupera todos os usuários com suas informações de endereço e imobiliária associadas.
     * Passa os dados para a view 'usuarios.index' para exibição.
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

        // Passa a lista para a view do formulário
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 1. REGRAS DE VALIDAÇÃO COMPLETAS, incluindo campos de endereço
        $validatedData = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email|max:150',
            'senha' => 'required|string|min:8|confirmed',
            'telefone1' => 'nullable|string|max:20',
            'telefone1_whatsapp' => 'boolean',
            'telefone2' => 'nullable|string|max:20',
            'telefone2_whatsapp' => 'boolean',
            'cpf' => 'required|string|unique:usuarios,cpf|max:45',
            'rg' => 'nullable|string|max:45',
            'orgao_emissor' => 'nullable|string|max:45',
            'data_nascimento' => 'nullable|date',
            'estado_civil' => 'nullable|string|max:20',
            'profissao' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:100',
            'cargo' => 'nullable|string|max:100',
            'salario' => 'nullable|string|max:20',
            'cep' => 'required|string|max:9', // <-- Validação para o CEP
            'creci' => 'nullable|string|unique:usuarios,creci|max:50',
            'foto_url' => 'nullable|url|max:255',
            'matricula' => 'nullable|string|unique:usuarios,matricula|max:50',
            'tipo_usuario' => 'required|in:administrador,corretor,cliente,proprietario,locatario,funcionario',
            'nivel_acesso' => 'nullable|integer', // <-- Validação do campo que será forçado pela lógica
            'ativo' => 'boolean',
            'receber_email' => 'boolean',
            'receber_sms' => 'boolean',
            'receber_whatsapp' => 'boolean',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'imobiliaria_id' => 'nullable|exists:imobiliarias,id',
            // Validações para os campos de endereço que vêm do ViaCEP
            'logradouro' => 'required|string|max:100',
            'numero' => 'required|string|max:10',
            'complemento' => 'nullable|string|max:50',
            'bairro' => 'required|string|max:50',
            'cidade' => 'required|string|max:50',
            'estado' => 'required|string|max:2', // UF
            [
                // MENSAGENS PERSONALIZADAS AQUI
                'nome_completo.required' => 'O nome completo é obrigatório.',
                'email.required' => 'O email é obrigatório.',
                'email.email' => 'Por favor, insira um endereço de email válido.',
                'email.unique' => 'Este email já está cadastrado.',
                'senha.required' => 'A senha é obrigatória.',
                'senha.min' => 'A senha deve ter no mínimo :min caracteres.',
                'senha.confirmed' => 'A confirmação de senha não corresponde.',
                'cpf.required' => 'O CPF é obrigatório.',
                'cpf.unique' => 'Este CPF já está cadastrado.',
                'creci.unique' => 'Este CRECI já está cadastrado.',
                'matricula.unique' => 'Esta matrícula já está cadastrada.',
                'endereco_id.exists' => 'O endereço selecionado não é válido.',
                'imobiliaria_id.exists' => 'A imobiliária selecionada não é válida.',
                'tipo_usuario.required' => 'O tipo de usuário é obrigatório.',
                'tipo_usuario.in' => 'O tipo de usuário selecionado é inválido.',
                'nivel_acesso.required' => 'O nível de acesso é obrigatório.',
                'cep.required' => 'O CEP é obrigatório.',
                'logradouro.required' => 'A rua/avenida é obrigatória.',
                'numero.required' => 'O número do endereço é obrigatório.',
                'bairro.required' => 'O bairro é obrigatório.',
                'cidade.required' => 'A cidade é obrigatória.',
                'estado.required' => 'O estado é obrigatório.', ],
        ]);

        // 2. LÓGICA PARA FORÇAR O NÍVEL DE ACESSO COM BASE NO TIPO DE USUÁRIO
        $tipoUsuarioAtribuido = $validatedData['tipo_usuario'];
        $nivelAcessoCalculado = 0;

        switch ($tipoUsuarioAtribuido) {
            case 'administrador': $nivelAcessoCalculado = 1;
                break;
            case 'corretor': $nivelAcessoCalculado = 2;
                break;
            case 'funcionario': $nivelAcessoCalculado = 3;
                break;
            default: $nivelAcessoCalculado = 4;
                break;
        }

        // 3. PREPARAR DADOS E CRIAR O ENDEREÇO
        $enderecoData = $request->only(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado']);
        $enderecoData['endereco'] = $enderecoData['logradouro'];
        unset($enderecoData['logradouro']);
        $enderecoData['localidade'] = $enderecoData['cidade'];
        $enderecoData['localizacao'] = $enderecoData['endereco'].', '.$enderecoData['numero'].' - '.$enderecoData['cidade'].'/'.$enderecoData['estado'];

        $novoEndereco = \App\Models\Endereco::create($enderecoData);

        // 4. PREPARAR DADOS DO USUÁRIO PARA CRIAÇÃO
        $userData = $validatedData;
        $userData['nivel_acesso'] = $nivelAcessoCalculado;
        $userData['endereco_id'] = $novoEndereco->id;

        // Limpar campos de endereço do array userData para não tentar salvar na tabela de usuários
        unset($userData['cep'], $userData['logradouro'], $userData['numero'], $userData['complemento'], $userData['bairro'], $userData['cidade'], $userData['estado']);

        // 5. CRIAR O USUÁRIO E REDIRECIONAR
        $usuario = new Usuario;
        $usuario->fill($userData);

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuário cadastrado com sucesso!');
    }

    /**
     * Exibe os detalhes de um usuário específico.
     *
     * Recupera um usuário pelo seu ID, incluindo seus endereços e imobiliárias relacionados,
     * e passa os dados para a view 'usuarios.show' para exibição.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show(\App\Models\Usuario $usuario)
    {
        // Para exibir os detalhes de endereço e imobiliária,
        // carregamos os relacionamentos (eager-loading)
        $usuario->load(['endereco', 'imobiliaria']);

        // Retorna a view 'usuarios.show', passando a instância do usuário.
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Exibe o formulário de edição para um usuário específico.
     *
     * Recupera o usuário pelo seu ID, juntamente com todos os endereços e imobiliárias disponíveis
     * para popular os campos de seleção (dropdowns) no formulário de edição. Em seguida, retorna a view
     * 'usuarios.edit' passando o usuário, endereços e imobiliárias como variáveis.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit(Usuario $usuario)
    {
        // Buscar todos os endereços e imobiliárias para popular os dropdowns
        $enderecos = Endereco::all();
        $imobiliarias = Imobiliaria::all();

        // Retorna a view 'usuarios.edit', passando o usuário, endereços e imobiliárias
        return view('usuarios.edit', compact('usuario', 'enderecos', 'imobiliarias'));
    }

    /**
     * Atualiza as informações de um usuário específico no banco de dados.
     *
     * Valida os dados recebidos da requisição para atualizar um usuário existente, garantindo que todos os campos obrigatórios
     * estejam presentes e corretamente formatados. Mensagens de validação personalizadas são fornecidas para maior clareza.
     *
     * As regras de validação incluem:
     * - Campos obrigatórios: nome_completo, email, cpf, tipo_usuario, nivel_acesso
     * - Restrições de unicidade: email, cpf, creci, matricula (ignorando o usuário atual)
     * - Verificações de formato e tamanho para strings, emails, datas e URLs
     * - Verificações booleanas para diversos flags (telefone1_whatsapp, telefone2_whatsapp, ativo, receber_email, receber_sms, receber_whatsapp)
     * - Verificação de existência para entidades relacionadas (endereco_id, imobiliaria_id)
     * - Validação ENUM para tipo_usuario
     * - Campos opcionais (nullable) para informações adicionais do usuário
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuario $usuario)
    {
        // Regras de validação para os campos que estão NO formulario do ADMINISTRADOR
        $validateData = $request->validate([
            'nome_completo' => 'required|string|max:255',
            'email' => 'required|email|max:150|unique:usuarios,email,'.$usuario->id,
            'telefone1' => 'nullable|string|max:20',
            'telefone1_whatsapp' => 'boolean',
            'telefone2' => 'nullable|string|max:20',
            'telefone2_whatsapp' => 'boolean',
            'endereco_id' => 'nullable|exists:enderecos,id',
            'cpf' => 'required|string|max:45|unique:usuarios,cpf,'.$usuario->id,
            'rg' => 'nullable|string|max:45',
            'orgao_emissor' => 'nullable|string|max:45',
            'data_nascimento' => 'nullable|date',
            'estado_civil' => 'nullable|string|max:20',
            'profissao' => 'nullable|string|max:100',
            'empresa' => 'nullable|string|max:100',
            'cargo' => 'nullable|string|max:100',
            'salario' => 'nullable|string|max:20',
            'cep' => 'nullable|string|max:10',
            'creci' => 'nullable|string|max:50|unique:usuarios,creci,'.$usuario->id,
            'foto_url' => 'nullable|url|max:255',
            'matricula' => 'nullable|string|max:50|unique:usuarios,matricula,'.$usuario->id,
            'tipo_usuario' => 'required|in:administrador,corretor,cliente,proprietario,locatario,funcionario',
            // 'nivel_acesso' não é mais validado como 'required' aqui, pois será FORÇADO pela lógica.
            // Mas pode ser 'nullable|integer' se o campo ainda existir no form e se for necessário validá-lo como número.
            'nivel_acesso' => 'nullable|integer',
            'ativo' => 'boolean',
            'receber_email' => 'boolean',
            'receber_sms' => 'boolean',
            'receber_whatsapp' => 'boolean',
            'instagram' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            // A imobiliária só pode ser alterada
        ]);
        // Tratamento dos checkboxes (todos os checkboxes do form)
        $userData = $validateData;
        $userData['telefone1_whatsapp'] = $request->has('telefone1_whatsapp');
        $userData['telefone2_whatsapp'] = $request->has('telefone2_whatsapp');
        $userData['ativo'] = $request->has('ativo');
        $userData['receber_email'] = $request->has('receber_email');
        $userData['receber_sms'] = $request->has('receber_sms');
        $userData['receber_whatsapp'] = $request->has('receber_whatsapp');
        /*
         * Lógica para forçar o nivel_acesso com base no tipo_usuario (mesma do store)
         * ... (seu código switch aqui, se você quiser forçar o nível na edição) ...
         * Se você quer que o administrador tenha controle total sobre o nivel_acesso, remova a lógica switch
         * Atualiza o usuário no banco de dados.
         * O método 'fill' preenche os campos que são 'fillable'.
         * O 'save' persistirá as mudanças.
         */
        $usuario->fill($userData);

        // Se a senha for fornecida no fomulário, vai ser hashiada e salvada
        if ($request->filled('senha')) {
            $usuario->senha = $request->input('senha');
        }

        $usuario->save();

        return redirect()->route('usuarios.index')->with('success', 'Usuario atualizado com sucesso!');

    }

    /**
     * Remove um usuário específico do banco de dados.
     *
     * Exclui o usuário identificado pelo ID fornecido. Após a exclusão, redireciona para a lista de usuários
     * com uma mensagem de sucesso.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usuario $usuario)
    {
        // Encontra o usuario pelo ID e o exclui
        $usuario->delete();

        // Redireciona para a lista de usuários com uma mensagem de sucesso
        return redirect()->route('usuarios.index')->with('success', 'Usuário excluído com sucesso!');
    }


    // -----------------------------------------------------------
        // MÉTODOS DE AUTENTICAÇÃO E DASHBOARD (FALTANDO)
        // -----------------------------------------------------------

        public function authenticate(Request $request) { /* Lógica de login: Auth::attempt() */ }
        public function logout(Request $request) { /* Lógica de logout: Auth::logout() */ }
        public function showRegisterForm() { /* Retorna view('auth.register') */ }
        public function registerUser(Request $request) { /* Lógica de cadastro público */ }

        // MÉTODOS DE REDIRECIONAMENTO E EXIBIÇÃO DE DASHBOARD
        public function redirecionamentoPorTipoUsuario(\App\Models\Usuario $usuario) { /* Lógica switch de redirecionamento */ }
        public function showAdminDashboard() { return view('dashboards.admin'); }
        public function showCorretorDashboard() { return view('dashboards.corretor'); }
        public function showFuncionarioDashboard() { return view('dashboards.funcionario'); }
        public function showClienteDashboard() { return view('dashboards.cliente'); }
}
