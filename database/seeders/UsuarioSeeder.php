<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Apaga todos os usuários existentes para garantir um estado limpo
        Usuario::truncate();

        // Cria o usuário administrador
        Usuario::create([
            'nome_completo' => 'Fernando Almeida',
            'email' => 'fernando@gmail.com',
            'senha' => Hash::make('senha123'), // Hashing da senha
            'cpf' => '99988877766', // Exemplo de CPF
            'tipo_usuario' => 'administrador',
            'nivel_acesso' => 1, // Nível mais alto
            'ativo' => true,
            
            // Campos com valores null na migração (se não for passado, o Eloquent insere null)
            'rg' => null,
            'orgao_emissor' => null,
            'data_nascimento' => null,
            'estado_civil' => null,
            'profissao' => null,
            'empresa' => null,
            'cargo' => null,
            'salario' => null,
            'cep' => null,
            'creci' => null,
            'foto_url' => null,
            'matricula' => null,
            'receber_email' => true,
            'receber_sms' => false,
            'receber_whatsapp' => false,
            'instagram' => null,
            'facebook' => null,
            'twitter' => null,
            'linkedin' => null,
            'telefone1' => '75999887766', // Exemplo de telefone
            'telefone1_whatsapp' => true,
            'telefone2' => null,
            'telefone2_whatsapp' => false,
            'endereco_id' => null,
            'imobiliaria_id' => null,
        ]);

        $this->command->info('Usuário administrador criado com sucesso!');
    }
}