@extends('layouts.dashboard') {{-- Estende o layout do dashboard --}}

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mb-3">Gestão de Usuários</h1>
        </div>
    </div>

    <div class="card shadow-sm mb-4"> {{-- Cartão para envolver a tabela --}}
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Lista de Usuários Cadastrados</span>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Criar Novo Usuário
            </a>
        </div>
        <div class="card-body">
            {{-- Mensagem de sucesso (se houver) --}}
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Tabela Responsiva para melhor visualização em telas menores --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle"> {{-- Classes Bootstrap para tabelas --}}
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">Email</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Tipo Usuário</th>
                            <th scope="col">Nível Acesso</th>
                            <th scope="col">Ativo</th>
                            <th scope="col" class="text-center">Ações</th> {{-- Coluna para os botões de ação --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($usuarios) > 0)
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <th scope="row">{{ $usuario->id }}</th>
                                    <td>{{ $usuario->nome_completo }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->cpf }}</td>
                                    <td><span class="badge bg-secondary">{{ ucfirst($usuario->tipo_usuario) }}</span></td>
                                    {{-- Badge para tipo --}}
                                    <td>{{ $usuario->nivel_acesso }}</td>
                                    <td>
                                        @if ($usuario->ativo)
                                            <span class="badge bg-success">Sim</span>
                                        @else
                                            <span class="badge bg-danger">Não</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{-- Botões de Ação --}}
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info btn-sm me-1"
                                            title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}" class="btn btn-warning btn-sm me-1"
                                            title="Editar Usuário">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="#" method="POST" class="d-inline"> {{-- Usar form para DELETE --}}
                                            @csrf {{-- Proteção CSRF --}}
                                            @method('DELETE') {{-- Método HTTP DELETE --}}
                                            <button type="submit" class="btn btn-danger btn-sm" title="Excluir Usuário"
                                                onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4">Nenhum usuário cadastrado ainda.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div> {{-- Fim table-responsive --}}
        </div> {{-- Fim card-body --}}
    </div> {{-- Fim card --}}
@endsection
