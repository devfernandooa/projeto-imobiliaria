<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Endereco;
use Exception;
use Illuminate\Support\Facades\Http;

class EnderecoController extends Controller
{
    /*
     * Pedimos a model endereco para trazer TOdos os endereços do banco de dados
     * e exibir na view 'enderecos.index'.
     */
    public function index()
    {
        $enderecos = Endereco::all();
        /**
         * Agora, 'empacotamos' esses endereços e os enviamos para a 'tela' (view).
         * A view 'enderecos.index' (resources/views/enderecos/index.blade.php)
         * receberá uma variável chamada 'enderecos' contendo os dados.
         */
        return view('enderecos.index', compact('enderecos'));
    }

      public function consultar(Request $request, $cep)
    {
        try {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/");

            if ($response->successful()) {
                $data = $response->json();
                return response()->json($data);
            } else {
                return response()->json(['error' => 'CEP não encontrado'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao consultar o CEP'], 500);
        }
    }


    public function store(Request $request)
    {
        $dados = $request->validate([
            'cep' => 'required|string|max:10',
            'logradouro' => 'required|string|max:255',
            'numero' => 'required|string|max:8',
            'bairro'   => 'required|string|max:255',
            'localidade' => 'required|string|max:255',
            'complemento' => 'required|string|max:255'

        ]);


        try {
            Endereco::create($dados);

            return view('/imovel/index');
        } catch (Exception $e) {
            return "Houve um problema ao cadastrar o endereço" . $e->getMessage();
        }
    }
}
