@extends('layouts.dashboard') {{-- EXTENDE O NOVO LAYOUT BASE DO DASHBOARD --}}

@section('content') {{-- O CONTEÚDO ESPECÍFICO DE CADA DASHBOARD VAI AQUI --}}
<div class="row">
    <div class="col-12">
        <h1 class="mb-3">Dashboard do Administrador</h1>
        <p>Este é o seu painel de controle administrativo. Aqui você terá acesso a todas as funcionalidades do sistema.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-4">
        <div class="card text-white bg-primary mb-3">
            <div class="card-header">Usuários Cadastrados</div>
            <div class="card-body">
                <h5 class="card-title">Total: {{ \App\Models\Usuario::count() }}</h5>
                <p class="card-text">Gerencie todos os usuários do sistema.</p>
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-light">Ver Usuários</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success mb-3">
            <div class="card-header">Imóveis Disponíveis</div>
            <div class="card-body">
                <h5 class="card-title">Total: 0</h5> {{-- Altere para o count de Imóveis quando tiver a Model --}}
                <p class="card-text">Visualize e gerencie os imóveis para venda/locação.</p>
                <a href="#" class="btn btn-outline-light">Ver Imóveis</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-info mb-3">
            <div class="card-header">Imobiliárias Parceiras</div>
            <div class="card-body">
                <h5 class="card-title">Total: {{ \App\Models\Imobiliaria::count() }}</h5>
                <p class="card-text">Gerencie as imobiliárias cadastradas.</p>
                <a href="{{ route('imobiliarias.index') }}" class="btn btn-outline-light">Ver Imobiliárias</a>
            </div>
        </div>
    </div>
</div>
@endsection