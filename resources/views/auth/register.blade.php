@extends('layouts.app') {{-- Extende o layout principal --}}

@section('content')
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6"> {{-- Formulário menor para cadastro público --}}
            <div class="card shadow-lg p-4">
                <h1 class="card-title text-center mb-4 text-primary">Cadastre-se Grátis</h1>

                {{-- Exibição de mensagens de erro de validação do Laravel --}}
                @if ($errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Mensagem de sucesso (se houver) --}}
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('register.store') }}" method="POST"> {{-- Ação para a nova rota de store --}}
                    @csrf

                    {{-- Informações Essenciais --}}
                    <div class="mb-3">
                        <label for="nome_completo" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="nome_completo" name="nome_completo" required value="{{ old('nome_completo') }}">
                        @error('nome_completo') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control form-control-sm" id="email" name="email" required value="{{ old('email') }}">
                        @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" id="cpf" name="cpf" required value="{{ old('cpf') }}">
                        @error('cpf') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    {{-- Senha --}}
                    <div class="mb-3">
                        <label for="senha" class="form-label">Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm" id="senha" name="senha" required>
                        @error('senha') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label for="senha_confirmation" class="form-label">Confirmar Senha <span class="text-danger">*</span></label>
                        <input type="password" class="form-control form-control-sm" id="senha_confirmation" name="senha_confirmation" required>
                        @error('senha_confirmation') <div class="text-danger small">{{ $message }}</div> @enderror
                    </div>

                    {{-- Botão de Submissão --}}
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i> Criar Conta
                        </button>
                    </div>
                </form>

                <div class="text-center mt-3">
                    <p class="mb-0">Já tem uma conta? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Faça Login</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection