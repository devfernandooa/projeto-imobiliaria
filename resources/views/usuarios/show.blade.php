@extends('layouts.dashboard')

@section('content')
<div class="row justify-content-center">
    <div class="col-12">
        <div class="card shadow-lg p-4 mb-5">
            <h1 class="card-title text-center mb-4 text-primary">Detalhes do Usuário</h1>

            <div class="mb-4 text-center">
                <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                    <i class="fas fa-arrow-left me-1"></i> Voltar para Lista
                </a>
            </div>

            {{-- Exibição de todos os detalhes em um formato de lista --}}
            <div class="row g-3">
                <div class="col-md-6">
                    <p><strong>Nome Completo:</strong> {{ $usuario->nome_completo }}</p>
                    <p><strong>Email:</strong> {{ $usuario->email }}</p>
                    <p><strong>CPF:</strong> {{ $usuario->cpf }}</p>
                    <p><strong>RG:</strong> {{ $usuario->rg ?? 'N/A' }}</p>
                    <p><strong>Órgão Emissor:</strong> {{ $usuario->orgao_emissor ?? 'N/A' }}</p>
                    <p><strong>Data de Nascimento:</strong> {{ $usuario->data_nascimento ? $usuario->data_nascimento->format('d/m/Y') : 'N/A' }}</p>
                    <p><strong>Estado Civil:</strong> {{ $usuario->estado_civil ?? 'N/A' }}</p>
                    <p><strong>Profissão:</strong> {{ $usuario->profissao ?? 'N/A' }}</p>
                    <p><strong>Empresa:</strong> {{ $usuario->empresa ?? 'N/A' }}</p>
                    <p><strong>Cargo:</strong> {{ $usuario->cargo ?? 'N/A' }}</p>
                    <p><strong>Salário:</strong> {{ $usuario->salario ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Telefone 1:</strong> {{ $usuario->telefone1 ?? 'N/A' }} ({{ $usuario->telefone1_whatsapp ? 'WhatsApp' : 'Não WhatsApp' }})</p>
                    <p><strong>Telefone 2:</strong> {{ $usuario->telefone2 ?? 'N/A' }} ({{ $usuario->telefone2_whatsapp ? 'WhatsApp' : 'Não WhatsApp' }})</p>
                    <p><strong>CEP do Usuário:</strong> {{ $usuario->cep ?? 'N/A' }}</p>
                    <p><strong>CRECI:</strong> {{ $usuario->creci ?? 'N/A' }}</p>
                    <p><strong>Matrícula:</strong> {{ $usuario->matricula ?? 'N/A' }}</p>
                    <p><strong>Tipo de Usuário:</strong> <span class="badge bg-secondary">{{ ucfirst($usuario->tipo_usuario) }}</span></p>
                    <p><strong>Nível de Acesso:</strong> {{ $usuario->nivel_acesso }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-{{ $usuario->ativo ? 'success' : 'danger' }}">{{ $usuario->ativo ? 'Ativo' : 'Inativo' }}</span></p>
                    <p><strong>Endereço Vinculado:</strong>
                        @if ($usuario->endereco)
                            {{ $usuario->endereco->logradouro }}, {{ $usuario->endereco->numero }} - {{ $usuario->endereco->bairro }}, {{ $usuario->endereco->cidade }}
                        @else
                            N/A
                        @endif
                    </p>
                    <p><strong>Imobiliária Vinculada:</strong>
                        @if ($usuario->imobiliaria)
                            {{ $usuario->imobiliaria->nome_fantasia }} ({{ $usuario->imobiliaria->cnpj }})
                        @else
                            N/A
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection