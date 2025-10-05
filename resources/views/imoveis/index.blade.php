@extends('layouts.dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-3">Gestão de Imóveis</h1>
    </div>
</div>

<div class="card shadow-sm mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span>Imóveis Cadastrados</span>
        <a href="{{ route('imoveis.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-1"></i> Cadastrar Novo Imóvel
        </a>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tipo</th>
                        <th scope="col">Endereço</th>
                        <th scope="col">Área (m²)</th>
                        <th scope="col">Status</th>
                        <th scope="col">Preço Venda/Locação</th>
                        <th scope="col" class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($imoveis as $imovel)
                    <tr>
                        <th scope="row">{{ $imovel->id }}</th>
                        <td>{{ ucfirst($imovel->tipo_imovel) }}</td>
                        <td>
                            @if ($imovel->endereco)
                                {{ $imovel->endereco->endereco ?? $imovel->endereco->logradouro }}, {{ $imovel->endereco->numero }}
                            @else
                                <span class="text-danger">Sem Endereço</span>
                            @endif
                        </td>
                        <td>{{ number_format($imovel->total_area, 2, ',', '.') }}</td>
                        <td><span class="badge bg-{{ $imovel->disponibilidade === 'venda' ? 'info' : ($imovel->disponibilidade === 'locacao' ? 'warning' : 'danger') }}">{{ ucfirst($imovel->disponibilidade) }}</span></td>
                        <td>V: R$ {{ number_format($imovel->preco_venda, 2, ',', '.') }} / L: R$ {{ number_format($imovel->preco_locacao, 2, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('imoveis.show', $imovel) }}" class="btn btn-info btn-sm me-1" title="Detalhes"><i class="fas fa-eye"></i></a>
                            <a href="{{ route('imoveis.edit', $imovel) }}" class="btn btn-warning btn-sm me-1" title="Editar"><i class="fas fa-edit"></i></a>
                            <button type="button" class="btn btn-danger btn-sm" title="Excluir"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">Nenhum imóvel cadastrado.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection