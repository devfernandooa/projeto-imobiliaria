@extends('layouts.app') {{-- Extende o layout principal --}}

@section('content')
<div class="container my-5">
    <div class="card shadow-lg p-4">
        <h1 class="card-title text-center mb-4 text-primary">Cadastre-se</h1>

        {{-- Botões de navegação --}}
        <div class="mb-4 text-center">
            <a href="/" class="btn btn-outline-secondary btn-sm me-2">
                <i class="fas fa-arrow-left me-1"></i> Voltar para Início
            </a>
        </div>

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

        <form action="{{ route('usuarios.store') }}" method="POST">
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
                    <label for="orgao_emissor" class="form-label">Órgão Emissor (RG)</label>
                    <input type="text" class="form-control form-control-sm" id="orgao_emissor" name="orgao_emissor" value="{{ old('orgao_emissor') }}">
                    @error('orgao_emissor') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                    <input type="date" class="form-control form-control-sm" id="data_nascimento" name="data_nascimento" value="{{ old('data_nascimento') }}">
                    @error('data_nascimento') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="estado_civil" class="form-label">Estado Civil</label>
                    <input type="text" class="form-control form-control-sm" id="estado_civil" name="estado_civil" value="{{ old('estado_civil') }}">
                    @error('estado_civil') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="profissao" class="form-label">Profissão</label>
                    <input type="text" class="form-control form-control-sm" id="profissao" name="profissao" value="{{ old('profissao') }}">
                    @error('profissao') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="empresa" class="form-label">Empresa</label>
                    <input type="text" class="form-control form-control-sm" id="empresa" name="empresa" value="{{ old('empresa') }}">
                    @error('empresa') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cargo" class="form-label">Cargo</label>
                    <input type="text" class="form-control form-control-sm" id="cargo" name="cargo" value="{{ old('cargo') }}">
                    @error('cargo') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="salario" class="form-label">Salário</label>
                    <input type="text" class="form-control form-control-sm" id="salario" name="salario" value="{{ old('salario') }}">
                    @error('salario') <div class="text-danger small">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control form-control-sm" id="cep" name="cep" value="{{ old('cep') }}">
                    @error('cep') <div class="text-danger small">{{ $message }}</div> @enderror
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

            {{-- Seção: Endereço (Relacionamento) - Mantido para permitir vincular endereço --}}
            <h4 class="mb-3 text-secondary">Vinculação de Endereço</h4>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
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
                {{-- Imobiliária_id removido para cadastro público, pois não é um cliente que escolhe a imobiliária --}}
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
                {{-- Nível de Acesso e Tipo de Usuário REMOVIDOS para cadastro público --}}
                {{-- CRECI, Matrícula, Foto URL, Redes Sociais REMOVIDOS para cadastro público --}}
                {{-- Checkboxes Ativo, Receber Email/SMS/WhatsApp REMOVIDOS para cadastro público --}}
            </div>

            {{-- Botão de Submissão --}}
            <div class="d-flex justify-content-center gap-2 mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-user-plus me-2"></i> Cadastrar
                </button>
                <a href="/" class="btn btn-outline-secondary btn-lg">
                    <i class="fas fa-arrow-alt-circle-left me-2"></i> Voltar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection