@extends('layouts.dashboard')

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg p-4 mb-5">
                <h1 class="card-title text-center mb-4 text-primary">Cadastrar Novo Imóvel</h1>

                {{-- Botões de navegação --}}
                <div class="mb-4 text-center">
                    <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary btn-sm me-2">
                        <i class="fas fa-arrow-left me-1"></i> Voltar para Lista de Imóveis
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

                <form action="{{ route('imoveis.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Seção 1: LOCALIZAÇÃO E VINCULAÇÃO --}}
                    <h4 class="mb-3 text-secondary">Localização e Vinculação</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label for="imobiliaria_id" class="form-label">Imobiliária Vinculada</label>
                            <select class="form-select form-select-sm @error('imobiliaria_id') is-invalid @enderror"
                                id="imobiliaria_id" name="imobiliaria_id">
                                <option value="">Nenhuma (Particular)</option>
                                @foreach ($imobiliarias as $imobiliaria)
                                    <option value="{{ $imobiliaria->id }}"
                                        {{ old('imobiliaria_id') == $imobiliaria->id ? 'selected' : '' }}>
                                        {{ $imobiliaria->nome_fantasia }}
                                    </option>
                                @endforeach
                            </select>
                            @error('imobiliaria_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- INÍCIO: CAMPOS DE ENDEREÇO PARA VIACEP --}}
                        <div class="col-md-3">
                            <label for="cep" class="form-label">CEP <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('cep') is-invalid @enderror"
                                id="cep" name="cep" required value="{{ old('cep') }}" maxlength="9"
                                placeholder="00000-000">
                            @error('cep')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-9">
                            <label for="logradouro" class="form-label">Rua/Avenida <span
                                    class="text-danger">*</span></label>
                            <input type="text"
                                class="form-control form-control-sm @error('logradouro') is-invalid @enderror"
                                id="logradouro" name="logradouro" required value="{{ old('logradouro') }}" readonly>
                            @error('logradouro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="numero" class="form-label">Número <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('numero') is-invalid @enderror"
                                id="numero" name="numero" required value="{{ old('numero') }}">
                            @error('numero')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text"
                                class="form-control form-control-sm @error('complemento') is-invalid @enderror"
                                id="complemento" name="complemento" value="{{ old('complemento') }}">
                            @error('complemento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="bairro" class="form-label">Bairro <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('bairro') is-invalid @enderror"
                                id="bairro" name="bairro" required value="{{ old('bairro') }}" readonly>
                            @error('bairro')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-2">
                            <label for="cidade" class="form-label">Cidade <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('cidade') is-invalid @enderror"
                                id="cidade" name="cidade" required value="{{ old('cidade') }}" readonly>
                            @error('cidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-1">
                            <label for="estado" class="form-label">UF <span class="text-danger">*</span></label>
                            <input type="text" class="form-control form-control-sm @error('estado') is-invalid @enderror"
                                id="estado" name="estado" required value="{{ old('estado') }}" maxlength="2" readonly>
                            @error('estado')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        {{-- FIM: CAMPOS DE ENDEREÇO PARA VIACEP --}}
                    </div>

                    {{-- Seção 2: DETALHES E VALORES --}}
                    <h4 class="mb-3 text-secondary">Características e Valores</h4>
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="tipo_imovel" class="form-label">Tipo de Imóvel <span
                                    class="text-danger">*</span></label>
                            {{-- ENUM: O Laravel armazena como string --}}
                            <select class="form-select form-select-sm @error('tipo_imovel') is-invalid @enderror"
                                id="tipo_imovel" name="tipo_imovel" required>
                                <option value="">Selecione o Tipo</option>
                                @foreach (['casa', 'predio', 'edificio', 'sala comercial', 'terreno', 'galpao', 'apartamento'] as $tipo)
                                    <option value="{{ $tipo }}"
                                        {{ old('tipo_imovel') == $tipo ? 'selected' : '' }}>
                                        {{ ucfirst($tipo) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_imovel')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="total_area" class="form-label">Área Total (m²) <span
                                    class="text-danger">*</span></label>
                            {{-- Decimal: Usamos type="number" com step="0.01" para precisão --}}
                            <input type="number" step="0.01"
                                class="form-control form-control-sm @error('total_area') is-invalid @enderror"
                                id="total_area" name="total_area" required value="{{ old('total_area') }}">
                            @error('total_area')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="comodos" class="form-label">Número de Cômodos</label>
                            <input type="number"
                                class="form-control form-control-sm @error('comodos') is-invalid @enderror"
                                id="comodos" name="comodos" value="{{ old('comodos') }}">
                            @error('comodos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="disponibilidade" class="form-label">Disponibilidade <span
                                    class="text-danger">*</span></label>
                            {{-- ENUM: Disponibilidade --}}
                            <select class="form-select form-select-sm @error('disponibilidade') is-invalid @enderror"
                                id="disponibilidade" name="disponibilidade" required>
                                <option value="">Selecione</option>
                                @foreach (['locacao', 'venda', 'indisponivel'] as $disp)
                                    <option value="{{ $disp }}"
                                        {{ old('disponibilidade') == $disp ? 'selected' : '' }}>
                                        {{ ucfirst($disp) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('disponibilidade')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="preco_venda" class="form-label">Preço de Venda (R$)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm @error('preco_venda') is-invalid @enderror"
                                id="preco_venda" name="preco_venda" value="{{ old('preco_venda') }}">
                            @error('preco_venda')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="preco_locacao" class="form-label">Preço de Locação (R$)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm @error('preco_locacao') is-invalid @enderror"
                                id="preco_locacao" name="preco_locacao" value="{{ old('preco_locacao') }}">
                            @error('preco_locacao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label for="descricao" class="form-label">Descrição Detalhada</label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" id="descricao" name="descricao"
                                rows="3">{{ old('descricao') }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Seção 3: CONDOMÍNIO E FOTOS --}}
                    <h4 class="mb-3 text-secondary">Condomínio e Mídia</h4>
                    <div class="row g-3 mb-4 align-items-center">
                        <div class="col-md-4">
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="possui_condominio"
                                    name="possui_condominio" value="1"
                                    {{ old('possui_condominio') ? 'checked' : '' }}>
                                <label class="form-check-label" for="possui_condominio">Possui Condomínio?</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="valor_taxa_condominio" class="form-label">Valor da Taxa (R$)</label>
                            <input type="number" step="0.01"
                                class="form-control form-control-sm @error('valor_taxa_condominio') is-invalid @enderror"
                                id="valor_taxa_condominio" name="valor_taxa_condominio"
                                value="{{ old('valor_taxa_condominio') }}">
                            @error('valor_taxa_condominio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label for="fotos" class="form-label">Fotos do Imóvel</label>
                            {{-- Input de Arquivo (Mídia) - Adicionamos 'multiple' para permitir várias fotos --}}
                            <input type="file"
                                class="form-control form-control-sm @error('fotos') is-invalid @enderror" id="fotos"
                                name="fotos[]" multiple>

                            <div id="file-count-feedback" class="form-text mt-1">
                                Mínimo de 5 fotos necessárias.
                            </div>
                            @error('fotos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Botão de Submissão --}}
                    <div class="d-flex justify-content-center gap-2 mt-4">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i> Cadastrar Imóvel
                        </button>
                        <a href="{{ route('imoveis.index') }}" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-arrow-alt-circle-left me-2"></i> Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
