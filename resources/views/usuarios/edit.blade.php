@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg p-4 mb-5">
                <h1 class="card-title text-center mb-4 text-primary">Editar Usuário</h1>

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

                <form action="{{ route('usuarios.update', $usuario) }}" method="POST">
                    @csrf
                    @method('PUT')

                    {{-- Seção: Informações Pessoais --}}
                    <h4 class="mb-3 text-secondary">Informações Pessoais</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="nome_completo" class="form-label">Nome Completo <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="nome_completo"
                                name="nome_completo" required value="{{ old('nome_completo', $usuario->nome_completo) }}">
                            @error('nome_completo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email"
                                required value="{{ old('email', $usuario->email) }}">
                            @error('email')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm" id="cpf" name="cpf"
                                required value="{{ old('cpf', $usuario->cpf) }}">
                            @error('cpf')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="rg" class="form-label">RG</label>
                            <input type="text" class="form-control form-control-sm" id="rg" name="rg"
                                value="{{ old('rg', $usuario->rg) }}">
                            @error('rg')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="orgao_emissor" class="form-label">Órgão Emissor (RG)</label>
                            <input type="text" class="form-control form-control-sm" id="orgao_emissor"
                                name="orgao_emissor" value="{{ old('orgao_emissor', $usuario->orgao_emissor) }}">
                            @error('orgao_emissor')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control form-control-sm" id="data_nascimento"
                                name="data_nascimento"
                                value="{{ old('data_nascimento', $usuario->data_nascimento ? $usuario->data_nascimento->format('Y-m-d') : '') }}">
                            @error('data_nascimento')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="estado_civil" class="form-label">Estado Civil</label>
                            <input type="text" class="form-control form-control-sm" id="estado_civil" name="estado_civil"
                                value="{{ old('estado_civil', $usuario->estado_civil) }}">
                            @error('estado_civil')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="profissao" class="form-label">Profissão</label>
                            <input type="text" class="form-control form-control-sm" id="profissao" name="profissao"
                                value="{{ old('profissao', $usuario->profissao) }}">
                            @error('profissao')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="empresa" class="form-label">Empresa</label>
                            <input type="text" class="form-control form-control-sm" id="empresa" name="empresa"
                                value="{{ old('empresa', $usuario->empresa) }}">
                            @error('empresa')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cargo" class="form-label">Cargo</label>
                            <input type="text" class="form-control form-control-sm" id="cargo" name="cargo"
                                value="{{ old('cargo', $usuario->cargo) }}">
                            @error('cargo')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="salario" class="form-label">Salário</label>
                            <input type="text" class="form-control form-control-sm" id="salario" name="salario"
                                value="{{ old('salario', $usuario->salario) }}">
                            @error('salario')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control form-control-sm" id="cep" name="cep"
                                value="{{ old('cep', $usuario->cep) }}">
                            @error('cep')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Seção: Contato --}}
                    <h4 class="mb-3 text-secondary">Informações de Contato</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="telefone1" class="form-label">Telefone 1 <span
                                    class="text-danger">*</span></label>
                            <input type="tel" class="form-control form-control-sm" id="telefone1" name="telefone1"
                                required value="{{ old('telefone1', $usuario->telefone1) }}">
                            @error('telefone1')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="telefone1_whatsapp"
                                    name="telefone1_whatsapp" value="1"
                                    {{ old('telefone1_whatsapp', $usuario->telefone1_whatsapp) ? 'checked' : '' }}>
                                <label class="form-check-label" for="telefone1_whatsapp">É WhatsApp?</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="telefone2" class="form-label">Telefone 2</label>
                            <input type="tel" class="form-control form-control-sm" id="telefone2" name="telefone2"
                                value="{{ old('telefone2', $usuario->telefone2) }}">
                            @error('telefone2')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                            <div class="form-check mt-2">
                                <input type="checkbox" class="form-check-input" id="telefone2_whatsapp"
                                    name="telefone2_whatsapp" value="1"
                                    {{ old('telefone2_whatsapp', $usuario->telefone2_whatsapp) ? 'checked' : '' }}>
                                <label class="form-check-label" for="telefone2_whatsapp">É WhatsApp?</label>
                            </div>
                        </div>
                    </div>

                    {{-- Seção: Vinculação (Endereço e Imobiliária) --}}
                    <h4 class="mb-3 text-secondary">Vinculação</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="endereco_id" class="form-label">Endereço</label>
                            <select class="form-select form-select-sm" id="endereco_id" name="endereco_id">
                                <option value="">Selecione um Endereço</option>
                                @foreach ($enderecos as $endereco)
                                    <option value="{{ $endereco->id }}"
                                        {{ old('endereco_id', $usuario->endereco_id) == $endereco->id ? 'selected' : '' }}>
                                        {{ $endereco->logradouro }}, {{ $endereco->numero }} -
                                        {{ $endereco->bairro ?? '' }} ({{ $endereco->cep }})
                                    </option>
                                @endforeach
                            </select>
                            @error('endereco_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="imobiliaria_id" class="form-label">Imobiliária</label>
                            <select class="form-select form-select-sm" id="imobiliaria_id" name="imobiliaria_id">
                                <option value="">Selecione uma Imobiliária</option>
                                @foreach ($imobiliarias as $imobiliaria)
                                    <option value="{{ $imobiliaria->id }}"
                                        {{ old('imobiliaria_id', $usuario->imobiliaria_id) == $imobiliaria->id ? 'selected' : '' }}>
                                        {{ $imobiliaria->nome_fantasia }} ({{ $imobiliaria->cnpj }})
                                    </option>
                                @endforeach
                            </select>
                            @error('imobiliaria_id')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Seção: Dados de Acesso e Permissões --}}
                    <h4 class="mb-3 text-secondary">Acesso e Permissões</h4>
                    <div class="row g-3 mb-4">
                        {{-- Em resources/views/usuarios/edit.blade.php, na seção "Acesso e Permissões" --}}
                        <div class="col-md-6">
                            <label for="senha" class="form-label">Nova Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control form-control-sm js-password-input"
                                    name="senha">
                                <button class="btn btn-outline-secondary btn-sm js-toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="form-text text-muted">Deixe em branco para não alterar a senha.</small>
                            @error('senha')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="senha_confirmation" class="form-label">Confirmar Nova Senha</label>
                            <input type="password" class="form-control form-control-sm" id="senha_confirmation"
                                name="senha_confirmation">
                            <small class="form-text text-muted">Repita a nova senha.</small>
                            @error('senha_confirmation')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tipo_usuario" class="form-label">Tipo de Usuário <span
                                    class="text-danger">*</span></label>
                            <select class="form-select form-select-sm" id="tipo_usuario" name="tipo_usuario" required>
                                <option value="">Selecione o Tipo</option>
                                @foreach (['administrador', 'corretor', 'cliente', 'proprietario', 'locatario', 'funcionario'] as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ old('tipo_usuario', $usuario->tipo_usuario) == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_usuario')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="nivel_acesso" class="form-label">Nível de Acesso <span
                                    class="text-danger">*</span></label>
                            <input type="number" class="form-control form-control-sm" id="nivel_acesso"
                                name="nivel_acesso" required value="{{ old('nivel_acesso', $usuario->nivel_acesso) }}">
                            @error('nivel_acesso')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="ativo" name="ativo"
                                    value="1" {{ old('ativo', $usuario->ativo) ? 'checked' : '' }}>
                                <label class="form-check-label" for="ativo">Usuário Ativo?</label>
                                @error('ativo')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="receber_email" name="receber_email"
                                    value="1" {{ old('receber_email', $usuario->receber_email) ? 'checked' : '' }}>
                                <label class="form-check-label" for="receber_email">Receber E-mail?</label>
                                @error('receber_email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="receber_sms" name="receber_sms"
                                    value="1" {{ old('receber_sms', $usuario->receber_sms) ? 'checked' : '' }}>
                                <label class="form-check-label" for="receber_sms">Receber SMS?</label>
                                @error('receber_sms')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="receber_whatsapp"
                                    name="receber_whatsapp" value="1"
                                    {{ old('receber_whatsapp', $usuario->receber_whatsapp) ? 'checked' : '' }}>
                                <label class="form-check-label" for="receber_whatsapp">Receber WhatsApp?</label>
                                @error('receber_whatsapp')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Seção: Detalhes Adicionais --}}
                    <h4 class="mb-3 text-secondary">Detalhes Adicionais</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="creci" class="form-label">CRECI (apenas para corretores)</label>
                            <input type="text" class="form-control form-control-sm" id="creci" name="creci"
                                value="{{ old('creci', $usuario->creci) }}">
                            @error('creci')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="matricula" class="form-label">Matrícula (apenas para funcionários)</label>
                            <input type="text" class="form-control form-control-sm" id="matricula" name="matricula"
                                value="{{ old('matricula', $usuario->matricula) }}">
                            @error('matricula')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="foto_url" class="form-label">URL da Foto (opcional)</label>
                            <input type="text" class="form-control form-control-sm" id="foto_url" name="foto_url"
                                value="{{ old('foto_url', $usuario->foto_url) }}">
                            @error('foto_url')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="instagram" class="form-label">Instagram URL</label>
                            <input type="text" class="form-control form-control-sm" id="instagram" name="instagram"
                                value="{{ old('instagram', $usuario->instagram) }}">
                            @error('instagram')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="facebook" class="form-label">Facebook URL</label>
                            <input type="text" class="form-control form-control-sm" id="facebook" name="facebook"
                                value="{{ old('facebook', $usuario->facebook) }}">
                            @error('facebook')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="twitter" class="form-label">Twitter URL</label>
                            <input type="text" class="form-control form-control-sm" id="twitter" name="twitter"
                                value="{{ old('twitter', $usuario->twitter) }}">
                            @error('twitter')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="linkedin" class="form-label">LinkedIn URL</label>
                            <input type="text" class="form-control form-control-sm" id="linkedin" name="linkedin"
                                value="{{ old('linkedin', $usuario->linkedin) }}">
                            @error('linkedin')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Botões de Ação --}}
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Salvar Alterações
                        </button>
                        <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-alt-circle-left me-2"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
