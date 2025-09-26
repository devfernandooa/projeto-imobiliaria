@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <h1 class="mb-3">Gestão de Usuários</h1>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Lista de Usuários Cadastrados</span>
            <a href="{{ route('usuarios.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-user-plus me-1"></i> Criar Novo Usuário
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome Completo</th>
                            <th scope="col">Email</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Tipo Usuário</th>
                            <th scope="col">Nível Acesso</th>
                            <th scope="col">Ativo</th>
                            <th scope="col" class="text-center">Ações</th>
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
                                    <td>{{ $usuario->nivel_acesso }}</td>
                                    <td>
                                        @if ($usuario->ativo)
                                            <span class="badge bg-success">Sim</span>
                                        @else
                                            <span class="badge bg-danger">Não</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('usuarios.show', $usuario) }}" class="btn btn-info btn-sm me-1"
                                            title="Ver Detalhes">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('usuarios.edit', $usuario) }}"
                                            class="btn btn-warning btn-sm me-1" title="Editar Usuário">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" title="Excluir Usuário"
                                            data-bs-toggle="modal" data-bs-target="#confirmDeleteModal{{ $usuario->id }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                                <div class="modal fade" id="confirmDeleteModal{{ $usuario->id }}" tabindex="-1"
                                    aria-labelledby="confirmDeleteModalLabel{{ $usuario->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmDeleteModalLabel{{ $usuario->id }}">
                                                    Confirmação de Exclusão</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body border rounded m-2 p-2 border-secondary text-center">
                                                <p class="text-center fs-5 mb-3">Tem certeza que deseja excluir o usuário:
                                                </p>
                                                <h5 class="text-center fw-semibold text-primary">
                                                    {{ $usuario->nome_completo }}?</h5>
                                                <p class="mt-2 fs-6"><svg xmlns="http://www.w3.org/2000/svg" width="32"
                                                        height="32" fill="currentColor"
                                                        class="bi bi-exclamation-octagon me-2 text-danger mt-2"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M4.54.146A.5.5 0 0 1 4.893 0h6.214a.5.5 0 0 1 .353.146l4.394 4.394a.5.5 0 0 1 .146.353v6.214a.5.5 0 0 1-.146.353l-4.394 4.394a.5.5 0 0 1-.353.146H4.893a.5.5 0 0 1-.353-.146L.146 11.46A.5.5 0 0 1 0 11.107V4.893a.5.5 0 0 1 .146-.353zM5.1 1 1 5.1v5.8L5.1 15h5.8l4.1-4.1V5.1L10.9 1z" />
                                                        <path
                                                            d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0M7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0z" />
                                                    </svg></p>
                                                <span class="text-danger">Essa ação não pode ser desfeita.</span>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('usuarios.destroy', $usuario) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Confirmar
                                                        Exclusão</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" class="text-center py-4">Nenhum usuário cadastrado ainda.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
