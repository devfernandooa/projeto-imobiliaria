<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imovel;
use App\Models\Endereco;
use App\Models\Imobiliaria;

class ImovelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela antes de popular
        Imovel::truncate();

        // 1. Buscar Dependências: Garantir que temos IDs válidos para FKs
        $enderecoPadrao = Endereco::first();
        $imobiliariaPadrao = Imobiliaria::first();

        // Verificação de segurança (O ImovelController@store já falharia, mas é bom prevenir no seeder)
        if (!$enderecoPadrao || !$imobiliariaPadrao) {
            $this->command->error("ERRO: Endereços e Imobiliárias são necessários. Execute os seeders anteriores primeiro.");
            return;
        }

        $enderecoId = $enderecoPadrao->id;
        $imobiliariaId = $imobiliariaPadrao->id;
        
        // Dados de Imóveis Fictícios (5 Tipos Diferentes)
        $imoveisData = [
            [
                'tipo_imovel' => 'Casa',
                'total_area' => 180.50,
                'qtde_comodos' => 5,
                'possui_condominio' => false,
                'valor_taxa_condominio' => null,
                'disponibilidade' => 'Venda',
                'preco_venda' => 850000.00,
                'preco_locacao' => null,
                'endereco_id' => $enderecoId,
                'descricao' => 'Casa moderna de 3 quartos no bairro planejado.'
            ],
            [
                'tipo_imovel' => 'Apartamento',
                'total_area' => 75.00,
                'qtde_comodos' => 3,
                'possui_condominio' => true,
                'valor_taxa_condominio' => 450.00,
                'disponibilidade' => 'Locação',
                'preco_venda' => null,
                'preco_locacao' => 2200.00,
                'endereco_id' => $enderecoId,
                'descricao' => 'Apartamento 2/4 em condomínio fechado com lazer.'
            ],
            [
                'tipo_imovel' => 'Sala Comercial',
                'total_area' => 55.30,
                'qtde_comodos' => 1,
                'possui_condominio' => true,
                'valor_taxa_condominio' => 300.00,
                'disponibilidade' => 'Venda',
                'preco_venda' => 350000.00,
                'preco_locacao' => null,
                'endereco_id' => $enderecoId,
                'descricao' => 'Sala ideal para escritório ou consultório.'
            ],
            [
                'tipo_imovel' => 'Terreno Urbano',
                'total_area' => 450.00,
                'qtde_comodos' => 0,
                'possui_condominio' => false,
                'valor_taxa_condominio' => null,
                'disponibilidade' => 'Indisponivel',
                'preco_venda' => 120000.00,
                'preco_locacao' => null,
                'endereco_id' => $enderecoPadrao->id, // Usa o mesmo endereço de teste
                'descricao' => 'Grande lote em área de expansão urbana.'
            ],
            [
                'tipo_imovel' => 'Galpão',
                'total_area' => 1200.00,
                 'qtde_comodos' => 5,
                'possui_condominio' => false,
                'valor_taxa_condominio' => null,
                'disponibilidade' => 'Locação',
                'preco_venda' => null,
                'preco_locacao' => 8000.00,
                'endereco_id' => $enderecoPadrao->id,
                'descricao' => 'Galpão industrial com área de manobra e escritório.'
            ]
        ];

        // Cria os registros
        foreach ($imoveisData as $data) {
            Imovel::create($data);
        }

        $this->command->info('5 imóveis de teste criados com sucesso!');
    }
}