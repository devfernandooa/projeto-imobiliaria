@extends('layouts.app') {{-- Extende o layout principal para ter a navbar e scripts --}}

@section('content')
<div class="container-fluid" style="margin-top: 80px; margin-bottom: 30px">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-7">
            <div class="card shadow-lg p-4">
                <h1 class="card-title text-center mb-4 text-primary">Cadastre-se</h1>

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

                <form action="{{ route('register.store') }}" method="POST">
                    @csrf

                    {{-- Seção: Informações Pessoais --}}
                    <h4 class="mb-3 text-secondary">Informações Pessoais</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nome_completo" class="form-label">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="nome_completo" name="nome_completo" required value="{{ old('nome_completo') }}">
                            @error('nome_completo') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" required value="{{ old('email') }}">
                            @error('email') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="cpf" name="cpf" required value="{{ old('cpf') }}">
                            @error('cpf') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control form-control-sm" id="rg" name="rg" value="{{ old('rg') }}">
                            @error('rg') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control form-control-sm" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
                            @error('data_nascimento') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Seção: Contato --}}
                    <h4 class="mb-3 text-secondary">Informações de Contato</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="telefone1" class="form-label">Telefone 1 <span class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm" id="telefone1" name="telefone1" required value="{{ old('telefone1') }}">
                            @error('telefone1') <div class="text-danger small">{{ $message }}</div> @enderror
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="telefone1_whatsapp" name="telefone1_whatsapp" value="1" {{ old('telefone1_whatsapp') ? 'checked' : '' }}>
                                <label class="form-check-label" for="telefone1_whatsapp">É WhatsApp?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone2" class="form-label">Telefone 2</label>
                            <input type="tel" class="form-control form-control-sm" id="telefone2" name="telefone2" value="{{ old('telefone2') }}">
                            @error('telefone2') <div class="text-danger small">{{ $message }}</div> @enderror
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="telefone2_whatsapp" name="telefone2_whatsapp" value="1" {{ old('telefone2_whatsapp') ? 'checked' : '' }}>
                                <label class="form-check-label" for="telefone2_whatsapp">É WhatsApp?</label>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3 text-secondary">Vinculação de Endereço</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-12"> {{-- Ocupa a linha inteira para o select de endereço --}}
                            <label for="endereco_id" class="form-label">Endereço</label>
                            <select class="form-select form-select-sm" id="endereco_id" name="endereco_id">
                                <option value="">Selecione um Endereço</option>
                                @foreach($enderecos as $endereco)
                                    <option value="{{ $endereco->id }}" {{ old('endereco_id') == $endereco->id ? 'selected' : '' }}>
                                        {{ $endereco->logradouro }}, {{ $endereco->numero }} - {{ $endereco->bairro ?? '' }} ({{ $endereco->cep }})
                                    </option>
                                @endforeach
                            </select>
                            @error('endereco_id') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>

                    </div>

                    {{-- Seção: Dados de Acesso --}}
                    <h4 class="mb-3 text-secondary">Dados de Acesso</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="senha" class="form-label">Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="senha" name="senha" required>
                            @error('senha') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="senha_confirmation" class="form-label">Confirmar Senha <span class="text-danger">*</span></label>
                            <input type="password" class="form-control form-control-sm" id="senha_confirmation" name="senha_confirmation" required>
                            @error('senha_confirmation') <div class="text-danger small">{{ $message }}</div> @enderror
                        </div>
                    <div class="text-center m-3">
                        <button type="submit" class="btn btn-primary w-25 mb-3">
                            <i class="fas fa-user-plus me-2"></i> Criar Conta
                        </button>
                        <p class="mb-0">Já tem uma conta? <a href="#" class="text-primary" data-bs-toggle="modal" data-bs-target="#loginModal">Faça Login</a></p>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection