@extends('layouts.dashboard') {{-- Estende o layout do dashboard --}}

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-3">Bem-vindo, {{ Auth::user()->nome_completo }}!</h1>
        <p class="lead">Este é o seu painel de controle. Aqui você pode gerenciar seu perfil, seus imóveis e seus contratos.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Meu Perfil</div>
            <div class="card-body">
                <h5 class="card-title">Atualize suas informações</h5>
                <p class="card-text">Veja e edite seus dados pessoais e de contato.</p>
                <a href="{{ route('cliente.dashboard') }}" class="btn btn-outline-light">Ver Perfil</a> {{-- Por enquanto, volta para o mesmo dashboard --}}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Meus Imóveis</div>
            <div class="card-body">
                <h5 class="card-title">Seus imóveis cadastrados</h5>
                <p class="card-text">Visualize os imóveis que você possui ou está alugando.</p>
                <a href="#" class="btn btn-outline-light">Ver Imóveis</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Meus Contratos</div>
            <div class="card-body">
                <h5 class="card-title">Contratos de locação/venda</h5>
                <p class="card-text">Acesse seus contratos e documentos importantes.</p>
                <a href="#" class="btn btn-outline-light">Ver Contratos</a>
            </div>
        </div>
    </div>
</div>
@endsection