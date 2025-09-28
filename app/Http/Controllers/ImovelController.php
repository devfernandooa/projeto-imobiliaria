<?php

namespace App\Http\Controllers;
use App\Models\Imovel;
use App\Models\Endereco; // <-- Necessário para criar o endereço
use App\Models\Imobiliaria; // Necessário
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class ImovelController extends Controller
{
    /**
     * Exibe uma lista de imóveis.
     *
     */

    public function index() 
    {
        $imoveis = Imovel::with(['endereco'])->get();
        return view('imoveis.index', compact('imoveis'));
    }

    public function store(Request $request)
    {
        // Regras de validação de imoveis e endereço
        $validatedData = $request->validate([
            'cep' => 'required|string|max:9',
            'logradouro' => 'required|string|max:100',
            'numero' => 'required|string|max:10',
            'bairro' => 'required|string|max:50',
            'cidade' => 'required|string|max:50',
            'estado' => 'required|string|max:2',

            // Validaçao de imóvel
            'tipo_imovel' => 'required|in:casa,predio,edificio,sala comercial, terreno, galpao, apartamento',
            'total_area' => 'required|numeric|min:1|max:999999.99',
            'qtde_comodos' => 'nullable|integer|min:0',
            'possui_condominio' => 'boolean',
            'valor_taxa_condominio' => 'nullable|numeric|min:0|max:999999.99',
            'preco_venda' => 'nullable|numeric|min:0|max:999999.99',
            'preco_locacao' => 'nullable|numeric|min:0|max:999999.99',
            'descricao' => 'nullable|string',
            'imobiliaria_id' => 'nullable|exists:imobiliarias,id',
            'fotos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',        
        
        ]);

        // INÍCIO DA TRANSAÇÃO (Para garantir que ou salva tudo, ou salva nada)
        DB::beginTransaction();
        try {

            // Prepara os dados do endereço
            $enderecoData =  $request->only(['cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade', 'estado']);

            // Mapeamento do nome do campo (Logradouro do form - Endereco do DB )
            $enderecoData['endereco'] = $enderecoData['logradouro'];
            unset($enderecoData['logradouro']);

            // Adiciona o campo localidade/localizacao, se for necessário no DB
            $enderecoData['localidade'] = $enderecoData['cidade'];
            $enderecoData['localizacao'] = $enderecoData['endereco'] . ', ' . $enderecoData['numero'];

            $novoEndereco = Endereco::create($enderecoData);

            // Prepara os dados do imóvel
            $imovelData = $validatedData;
            $imovelData['endereco_id'] = $novoEndereco->id;

            // Trata o checkboc se possui condominio
            $imovelData['possui_condominio'] = $request->has('possui_condominio');

            // Cria o imóvel e faz o upload das fotos
            $imovel = Imovel::create($imovelData);

            DB::commit();
            return redirect()->route('imoveis.index')->with('success', 'Imóvel cadastrado com sucesso!');
             
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Ocorreu um erro ao cadastrar o imóvel.');
        }
    }


    /**
     * Exibe o formulário para cadastrar um novo imóvel.
     */
    public function create()
    {
        // Busca todos os endereços e imobiliárias para os dropdowns no formulário.
        // O namespace completo é usado para garantir que o Docker o encontre.
        $enderecos = \App\Models\Endereco::all();
        $imobiliarias = \App\Models\Imobiliaria::all();

        // Retorna a view 'imoveis.create', passando os dados.
        return view('imoveis.create', compact('enderecos', 'imobiliarias'));
    }


}
