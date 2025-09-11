<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Importar o Facade DB

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Desabilitar temporariamente a verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            //EnderecoSeeder::class,
            //ImobiliariaSeeder::class,
            UsuarioSeeder::class
            // Adicione outros seeders aqui. A ordem é importante para dependências!
            // Por exemplo, UsuarioSeeder::class viria depois de Endereco e Imobiliaria
            // ImovelSeeder::class viria depois de Endereco
            // FotosImoveisSeeder::class viria depois de Imovel
        ]);

        // Habilitar novamente a verificação de chaves estrangeiras
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Banco de dados semeado com sucesso!');
    }
}