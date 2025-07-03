<?php

namespace App\Models;

Use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Mudar para Authenticatable para usar autenticação do Laravel
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    
    use HasFactory, Notifiable;

    protected $table = 'usuarios'; // Define a tabela associada ao modelo
    
    public function getAuthPasswordName()
    {
        // Substitua 'senha' pelo nome exato da sua coluna de senha
        return 'senha';
    }

    /**
     * Os atributos que não devem ser atribuídos em massa.
     * Use $guarded quando a lista de campos protegidos for menor que a lista de campos fillable.
     * Ou quando você quer explicitamente proteger campos sensíveis.
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at', // remover o update_at caso seja necessário edidar a data da ultima atualização
        'remember_token',
        'tipo_usuario', // Sensivel: tipo do perfil do usuário
        'nivel_acesso', // Sensivel: nivel de permissão
        'ativo', // Status: ativo/inativo 
        'imobiliaria_id',
        //Caso tenha outros campos que NUNCA devem ser preenchiidos diretamente
    ];

    /**
     * Oculta o campo de senha e remember_token ao serializar o modelo.
     */
    protected $hidden =  [
        'senha',
        'remember_token',
    ];

    /**
     * Esses atributos devem ser convertidos para tipos nativos do PHP
     */
     protected $casts = [
    'data_nascimento' => 'date',
    'telefone1_whatsapp' => 'boolean',
    'telefone2_whatsapp' => 'boolean',
    'ativo' => 'boolean',
    'receber_email' => 'boolean',
    'receber_sms' => 'boolean',
    'receber_whatsapp' => 'boolean',
    'senha' => 'hashed', // Hash sensível: senha do usuário
];



     
     // --- Relacionamentos ---

    // Um usuário pertence a uma imobiliária 'belongsTo' - Muitos para um
    public function imobiliaria()
    {
        return $this->belongsTo(Imobiliaria::class);
    }

    // Um usuário tem um endereço 'hasOne' - Um para um
    public function endereco()
    {
        return $this->belongsTo(Endereco::class);
    }
}
