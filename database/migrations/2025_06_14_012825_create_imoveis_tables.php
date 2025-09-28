<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * abela: Imoveis
         * Descrição: Armazena informações detalhadas sobre os imóveis disponíveis.
         */
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_imovel', [
                'Casa', 'Prédio', 'Edifício', 'Sala Comercial', 'Apartamento',
                'Terreno Urbano', 'Terreno Rural', 'Galpão', 'Sítio', 'Chácara', 'Outro',
            ]);
            $table->decimal('total_area', 10, 2)->nullable();
            $table->integer('qtde_comodos')->nullable();
            $table->boolean('possui_condominio')->default(false);
            $table->decimal('valor_taxa_condominio', 10, 2)->nullable();
            $table->enum('disponibilidade', ['Locação', 'Venda', 'Indisponível']);
            $table->decimal('preco_venda', 10, 2)->nullable();
            $table->decimal('preco_locacao', 10, 2)->nullable();
            $table->foreignId('endereco_id')->constrained('enderecos');
            $table->text('descricao')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('imoveis_tables');
    }
};
