<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    // AQUI: adicionamos os campos que podem ser preenchidos em massa
    protected $fillable = [
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'localidade',
        'localizacao',
        'bloco',
        'andar',
        'sala',
        'apartamento',
    ];

    // Um enderço pode está relacionando a um uduário
    public function usuario()
    {
        return $this->hasOne(Usuario::class);
    }

    // Um endereço pode está relacionando a uma Imobiliária
    public function imobiliaria()
    {
        return $this->hasOne(Imobiliaria::class);
    }

    // Um endereço pode está relacionando a um Imóvel
    public function imovel()
    {
        return $this->hasOne(Imovel::class);
    }
}
