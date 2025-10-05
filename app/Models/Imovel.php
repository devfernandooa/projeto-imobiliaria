<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Endereco;    
use App\Models\Imobiliaria; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class Imovel extends Model
{
    use HasFactory;

     // Informa ao Laravel que a tabela associada a este modelo é imoveis
    protected $table = 'imoveis';

    // AQUI: adicionamos os campos que podem ser preenchidos em massa
    protected $fillable = [
        'tipo_imovel',
        'total_area',
        'qtde_comodos',
        'possui_condominio',
        'valor_taxa_condominio',
        'preco_venda',
        'preco_locacao',
        'endereco_id',
        'descricao',
    ];  


    // Um imóvel pertence a uma imobiliária 'belongsTo' - Muitos para um
    public function imobiliaria()
    {
        return $this->belongsTo(Imobiliaria::class);
    }

    // Um imóvel tem um endereço 'hasOne' - Um para um
    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id', 'id');

        
    }

    // Um imovel tem muitas fotos 'hasMany' - Um para muitos
    public function fotos()
    {
        return $this->hasMany(FotoImovel::class);
    }
}
