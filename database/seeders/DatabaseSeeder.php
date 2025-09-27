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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->call([
            // GARANTA QUE O SEEDER ESTÁ AQUI NA LISTA DE CHAMADAS
            UsuarioAdminSeeder::class, // <--- VERIFIQUE ESTA LINHA!
            //EnderecoSeeder::class,     // Exemplo
            ImobiliariaSeeder::class,  // Exemplo
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}