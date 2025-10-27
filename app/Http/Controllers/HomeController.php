<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index() 
    {
        $imoveis = Imovel::with(['endereco', 'fotos'])
                            ->whereIn('disponibilidade', ['Locação', 'Venda'])
                            ->latest()
                            ->take(8) // Limita a 8 imóveis
                            ->get();
        // Retorna a view 'index.blade.php', passando a coleção de imóveis
        return view('index', compact('imoveis'));
    }
}
