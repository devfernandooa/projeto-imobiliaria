<?php

namespace Database\Seeders;

// Em database/seeders/DatabaseSeeder.php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UsuarioAdminSeeder; // Adicione esta linha no topo!
use Database\Seeders\EnderecoSeeder; // Se existirem
use Database\Seeders\ImobiliariaSeeder; // Se existirem

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
  public function run(): void
    {
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            // Ordem Corrigida:
            \Database\Seeders\ImobiliariaSeeder::class,   // <--- Cria Imobiliárias e seus Endereços
            \Database\Seeders\UsuarioAdminSeeder::class,  // <--- Cria o Admin e vincula a Imobiliária e o Endereço de Teste
            \Database\Seeders\ImovelSeeder::class,       // <--- Cria Imóveis e seus Endereços
        ]);

        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}