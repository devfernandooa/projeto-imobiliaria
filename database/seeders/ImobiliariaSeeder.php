<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imobiliaria;
use App\Models\Endereco; // <--- Model Endereco para criar a dependência

class ImobiliariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Imobiliaria::truncate(); // Limpa a tabela de imobiliárias
        Endereco::truncate();    // <--- Limpa Endereços AQUI, pois os endereços anteriores eram de teste para a imobiliária

        // 1. Cria o Endereço de Teste para a Imobiliária
        $enderecoImob1 = Endereco::create([
            'endereco' => 'Rua Principal da Imobiliária',
            'numero' => '1',
            'cep' => '90001-001',
            'localizacao' => 'Escritório Central',
            'bairro' => 'Centro',
            'cidade' => 'Feira de Santana',
            'estado' => 'BA',
            'localidade' => 'Feira de Santana',
        ]);

        // Cria a Imobiliária, vinculando o ID do Endereço
        Imobiliaria::create([
            'nome_fantasia' => 'Imob Prime',
            'razao_social' => 'Imob Prime S/A',
            'cnpj' => '00.000.000/0001-00',
            'endereco_id' => $enderecoImob1->id, // <--- Vinculação direta
            'telefone' => '(75) 3221-1234',
            'email' => 'contato@imobprime.com.br',
            'creci' => 'PJ12345',
            'logo_url' => 'https://example.com/logo-prime.png',
        ]);

      
        $this->command->info('Imobiliárias e seus endereços de teste criados com sucesso!');
    }
}