@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg p-4 mb-5">
                <h1 class="card-title text-center mb-4 text-primary">Cadastrar Novo Usuário (Admin)</h1>

                <div class="mb-4 text-center">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="fas fa-arrow-left me-1"></i> Voltar para Lista de Usuários
                    </a>
                </div>

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

                    {{-- Informações Pessoais --}}
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="float-none w-auto px-3 fs-5 text-secondary">Informações Pessoais</legend>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="nome_completo" class="form-label">Nome Completo <span
                                        class="text-danger">*</span></label>
                                <input type="text"
                                    class="form-control form-control-sm @error('nome_completo') is-invalid @enderror"
                                    id="nome_completo" name="nome_completo" required value="{{ old('nome_completo') }}">
                                @error('nome_completo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control form-control-sm @error('email') is-invalid @enderror"
                                    id="email" name="email" required value="{{ old('email') }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('cpf') is-invalid @enderror"
                                    id="cpf" name="cpf" maxlength="14" required value="{{ old('cpf') }}">
                                @error('cpf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="rg" class="form-label">RG</label>
                                <input type="text" class="form-control form-control-sm @error('rg') is-invalid @enderror"
                                    id="rg" name="rg" maxlength="12" value="{{ old('rg') }}">
                                @error('rg')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="orgao_emissor" class="form-label">Órgão Emissor</label>
                                <input type="text" class="form-control form-control-sm @error('orgao_emissor') is-invalid @enderror"
                                    id="orgao_emissor" name="orgao_emissor" maxlength="10" value="{{ old('orgao_emissor') }}">
                                @error('orgao_emissor')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 col-lg-2">
                                <label for="data_nascimento" class="form-label">Nascimento</label>
                                <input type="date" class="form-control form-control-sm @error('data_nascimento') is-invalid @enderror" id="data_nascimento"
                                    name="data_nascimento" value="{{ old('data_nascimento') }}">
                                @error('data_nascimento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="estado_civil" class="form-label">Estado Civil</label>
                                <input type="text" class="form-control form-control-sm @error('estado_civil') is-invalid @enderror" id="estado_civil"
                                    name="estado_civil" maxlength="20" value="{{ old('estado_civil') }}">
                                @error('estado_civil')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="profissao" class="form-label">Profissão</label>
                                <input type="text" class="form-control form-control-sm @error('profissao') is-invalid @enderror" id="profissao"
                                    maxlength="30" value="{{ old('profissao') }}">
                                @error('profissao')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="empresa" class="form-label">Empresa</label>
                                <input type="text" class="form-control form-control-sm" id="empresa" name="empresa"
                                    maxlength="30" value="{{ old('empresa') }}">
                                @error('empresa')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="cargo" class="form-label">Cargo</label>
                                <input type="text" class="form-control form-control-sm" id="cargo" name="cargo"
                                    maxlength="30" value="{{ old('cargo') }}">
                                @error('cargo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-2">
                                <label for="salario" class="form-label">Salário</label>
                                <input type="text" class="form-control form-control-sm" id="salario" name="salario"
                                    maxlength="12" value="{{ old('salario') }}">
                                @error('salario')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Endereço --}}
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="float-none w-auto px-3 fs-5 text-secondary">Endereço</legend>
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="cep" class="form-label">CEP</label>
                                <input type="text" class="form-control form-control-sm" id="cep" name="cep"
                                    maxlength="9" value="{{ old('cep') }}">
                                @error('cep')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-8 col-lg-5">
                                <label for="logradouro" class="form-label">Logradouro</label>
                                <input type="text" class="form-control form-control-sm" id="logradouro"
                                    name="logradouro" maxlength="100" value="{{ old('logradouro') }}">
                                @error('logradouro')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2 col-lg-1">
                                <label for="numero" class="form-label">Número</label>
                                <input type="text" class="form-control form-control-sm" id="numero" name="numero"
                                    maxlength="10" value="{{ old('numero') }}">
                                @error('numero')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="complemento" class="form-label">Complemento</label>
                                <input type="text" class="form-control form-control-sm" id="complemento"
                                    name="complemento" maxlength="50" value="{{ old('complemento') }}">
                                @error('complemento')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="bairro" class="form-label">Bairro</label>
                                <input type="text" class="form-control form-control-sm" id="bairro" name="bairro"
                                    maxlength="50" value="{{ old('bairro') }}">
                                @error('bairro')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="cidade" class="form-label">Cidade</label>
                                <input type="text" class="form-control form-control-sm" id="cidade" name="cidade"
                                    maxlength="50" value="{{ old('cidade') }}">
                                @error('cidade')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="uf" class="form-label">UF</label>
                                <input type="text" class="form-control form-control-sm" id="estado" name="estado"
                                    maxlength="2" value="{{ old('uf') }}">
                                @error('uf')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Informações de Contato --}}
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="float-none w-auto px-3 fs-5 text-secondary">Contato</legend>
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="telefone1" class="form-label">Telefone 1 <span
                                        class="text-danger">*</span></label>
                                <input type="tel" class="form-control form-control-sm" id="telefone1"
                                    name="telefone1" maxlength="15" required value="{{ old('telefone1') }}">
                                @error('telefone1')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="telefone1_whatsapp"
                                        name="telefone1_whatsapp" value="1"
                                        {{ old('telefone1_whatsapp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="telefone1_whatsapp">É WhatsApp?</label>
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="telefone2" class="form-label">Telefone 2</label>
                                <input type="tel" class="form-control form-control-sm" id="telefone2"
                                    name="telefone2" maxlength="15" value="{{ old('telefone2') }}">
                                @error('telefone2')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                <div class="form-check mt-2">
                                    <input type="checkbox" class="form-check-input" id="telefone2_whatsapp"
                                        name="telefone2_whatsapp" value="1"
                                        {{ old('telefone2_whatsapp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="telefone2_whatsapp">É WhatsApp?</label>
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Acesso e Permissões --}}
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="float-none w-auto px-3 fs-5 text-secondary">Acesso e Permissões</legend>
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="senha" class="form-label">Senha <span class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" id="senha"
                                    name="senha" required>
                                @error('senha')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="senha_confirmation" class="form-label">Confirmar Senha <span
                                        class="text-danger">*</span></label>
                                <input type="password" class="form-control form-control-sm" id="senha_confirmation"
                                    name="senha_confirmation" required>
                                @error('senha_confirmation')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="tipo_usuario" class="form-label">Tipo de Usuário <span
                                        class="text-danger">*</span></label>
                                <select class="form-select form-select-sm" id="tipo_usuario" name="tipo_usuario"
                                    required>
                                    <option value="">Selecione o Tipo</option>
                                    <option value="administrador"
                                        {{ old('tipo_usuario') == 'administrador' ? 'selected' : '' }}>Administrador
                                    </option>
                                    <option value="corretor" {{ old('tipo_usuario') == 'corretor' ? 'selected' : '' }}>
                                        Corretor</option>
                                    <option value="cliente" {{ old('tipo_usuario') == 'cliente' ? 'selected' : '' }}>
                                        Cliente</option>
                                    <option value="proprietario"
                                        {{ old('tipo_usuario') == 'proprietario' ? 'selected' : '' }}>Proprietário</option>
                                    <option value="locatario" {{ old('tipo_usuario') == 'locatario' ? 'selected' : '' }}>
                                        Locatário</option>
                                    <option value="funcionario"
                                        {{ old('tipo_usuario') == 'funcionario' ? 'selected' : '' }}>Funcionário</option>
                                </select>
                                @error('tipo_usuario')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3 d-none">
                                <input type="hidden" class="form-control form-control-sm" id="nivel_acesso"
                                    name="nivel_acesso" value="{{ old('nivel_acesso') ?? 4 }}" readonly>
                                @error('nivel_acesso')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mt-2">
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="ativo" name="ativo"
                                        value="1" {{ old('ativo', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="ativo">Usuário Ativo?</label>
                                    @error('ativo')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="receber_email"
                                        name="receber_email" value="1"
                                        {{ old('receber_email', 1) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="receber_email">Receber E-mail?</label>
                                    @error('receber_email')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="receber_sms" name="receber_sms"
                                        value="1" {{ old('receber_sms') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="receber_sms">Receber SMS?</label>
                                    @error('receber_sms')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-check form-check-inline">
                                    <input type="checkbox" class="form-check-input" id="receber_whatsapp"
                                        name="receber_whatsapp" value="1"
                                        {{ old('receber_whatsapp') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="receber_whatsapp">Receber WhatsApp?</label>
                                    @error('receber_whatsapp')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </fieldset>

                    {{-- Detalhes Adicionais --}}
                    <fieldset class="border rounded-3 p-3 mb-4">
                        <legend class="float-none w-auto px-3 fs-5 text-secondary">Detalhes Adicionais</legend>
                        <div class="row g-3">
                            <div class="col-md-4 col-lg-3">
                                <label for="creci" class="form-label">CRECI (corretor)</label>
                                <input type="text" class="form-control form-control-sm" id="creci" name="creci"
                                    maxlength="20" value="{{ old('creci') }}">
                                @error('creci')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="matricula" class="form-label">Matrícula (funcionário)</label>
                                <input type="text" class="form-control form-control-sm" id="matricula"
                                    name="matricula" maxlength="20" value="{{ old('matricula') }}">
                                @error('matricula')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="foto_url" class="form-label">URL da Foto</label>
                                <input type="text" class="form-control form-control-sm" id="foto_url"
                                    name="foto_url" maxlength="255" value="{{ old('foto_url') }}">
                                @error('foto_url')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="instagram" class="form-label">Instagram URL</label>
                                <input type="text" class="form-control form-control-sm" id="instagram"
                                    name="instagram" maxlength="100" value="{{ old('instagram') }}">
                                @error('instagram')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="facebook" class="form-label">Facebook URL</label>
                                <input type="text" class="form-control form-control-sm" id="facebook"
                                    name="facebook" maxlength="100" value="{{ old('facebook') }}">
                                @error('facebook')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="twitter" class="form-label">Twitter URL</label>
                                <input type="text" class="form-control form-control-sm" id="twitter" name="twitter"
                                    maxlength="100" value="{{ old('twitter') }}">
                                @error('twitter')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 col-lg-3">
                                <label for="linkedin" class="form-label">LinkedIn URL</label>
                                <input type="text" class="form-control form-control-sm" id="linkedin"
                                    name="linkedin" maxlength="100" value="{{ old('linkedin') }}">
                                @error('linkedin')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </fieldset>

                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-sm px-4">
                            <i class="fas fa-save me-2"></i> Salvar
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-sm px-4">
                            <i class="fas fa-arrow-alt-circle-left me-2"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
