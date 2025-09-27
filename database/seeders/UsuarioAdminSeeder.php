<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;
use App\Models\Endereco;   // <--- Importe a Model Endereco
use App\Models\Imobiliaria; // <--- Importe a Model Imobiliaria

class UsuarioAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuario::truncate();

        // 1. DADOS DE ENDEREÇO PARA O ADMIN (ViaCEP mock)
        $enderecoAdmin = Endereco::create([
            'endereco' => 'Rua da Administração Central',
            'numero' => '1000',
            'bloco' => 'A',
            'cep' => '44000-001',
            'localizacao' => 'Escritório Matriz',
            'complemento' => 'Sala 101',
            'bairro' => 'Centro Admin',
            'cidade' => 'Feira de Santana',
            'estado' => 'BA',
            'localidade' => 'Feira de Santana',
        ]);
        
        // 2. BUSCAR UMA IMOBILIÁRIA EXISTENTE (assumindo que o ImobiliariaSeeder rodou primeiro)
        $imobiliariaPadrao = Imobiliaria::first(); 
        
        // 3. CRIAÇÃO DO USUÁRIO ADMINISTRADOR
        Usuario::create([
            'nome_completo' => 'Administrador ImobPrime',
            'email' => 'admin@imobprime.com',
            'senha' => Hash::make('senha123'),
            'cpf' => '99988877766',
            'tipo_usuario' => 'administrador',
            'nivel_acesso' => 1,
            'ativo' => true,
            
            // VINCULAÇÃO
            'endereco_id' => $enderecoAdmin->id, // <--- ID do endereço recém-criado
            'imobiliaria_id' => $imobiliariaPadrao ? $imobiliariaPadrao->id : null, // ID da imobiliária (se existir)

            // DEMAIS CAMPOS OBRIGATÓRIOS (NOT NULL sem default)
            'telefone1' => '75999887766',
            'telefone1_whatsapp' => true,
        ]);

        $this->command->info('Usuário administrador criado com sucesso e endereço vinculado!');
    }
}