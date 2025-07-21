<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Imobiliaria; // Importe a Model Imobiliaria
use App\Models\Endereco; // Para buscar um Endereco para o relacionamento

class ImobiliariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpa a tabela antes de popular
        Imobiliaria::truncate(); // CUIDADO: Isso apaga TODOS os dados da tabela Imobiliarias!

        // Recupera alguns IDs de endereço para associar às imobiliárias
        $endereco1 = Endereco::first(); // Pega o primeiro endereço que foi criado pelo EnderecoSeeder
        //$endereco2 = Endereco::skip(1)->first(); // Pega o segundo

        Imobiliaria::create([
            'nome_fantasia' => 'Imob Prime',
            'razao_social' => 'Imob Prime Ltda',
            'cnpj' => '00.000.000/0001-00',
            'endereco_id' => $endereco1 ? $endereco1->id : null, // Associa ao primeiro endereço
            'telefone' => '(75) 3221-1234',
            'email' => 'contato@imobprime.com.br',
            'creci' => 'PJ12345',
            'logo_url' => 'https://example.com/logo-prime.png',
        ]);

        // Imobiliaria::create([
        //     'nome_fantasia' => 'Lar Doce Lar Imóveis',
        //     'razao_social' => 'Lar Doce Lar Imoveis S/A',
        //     'cnpj' => '11.111.111/0001-11',
        //     'endereco_id' => $endereco2 ? $endereco2->id : null, // Associa ao segundo endereço
        //     'telefone' => '(75) 3333-5555',
        //     'email' => 'contato@lardocelar.com',
        //     'creci' => 'PJ67890',
        //     'logo_url' => 'https://example.com/logo-lar.png',
        // ]);

        $this->command->info('Imobiliária criada com sucesso!');
    }
}