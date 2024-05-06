<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('categoria');
            $table->string('familia');
            $table->unsignedBigInteger('id_familia');
            $table->string('subfamilia');
            $table->unsignedBigInteger('id_subfamilia');
            $table->string('referencia');
            $table->string('titulo');
            $table->string('titulo_small');
            $table->text('descripcion');
            $table->string('fabricante');
            $table->unsignedBigInteger('id_fabricante');
            $table->string('ean');
            $table->string('pn');
            $table->decimal('pvd', 10, 3);
            $table->decimal('pvd_estandar', 10, 3);
            $table->decimal('pvp', 10, 3);
            $table->decimal('margen', 10, 3);
            $table->decimal('margen_pvp', 10, 3);
            $table->decimal('margen_oferta_pvp', 10, 3)->nullable();
            $table->boolean('oferta');
            $table->decimal('oferta_pvd', 10, 3)->nullable();
            $table->decimal('oferta_discount', 10, 3)->nullable();
            $table->date('oferta_date_of')->nullable();
            $table->date('oferta_date_to')->nullable();
            $table->boolean('canon');
            $table->integer('stock');
            $table->string('stockstatus');
            $table->boolean('bajo_demanda');
            $table->decimal('peso', 10, 3);
            $table->boolean('liquidacion');
            $table->string('url_imagen');
            $table->string('url_imagen_compress');
            $table->text('images')->nullable();
            $table->date('fecha_alta');
            $table->string('url_product');
            $table->string('proveedor');
            $table->text('cualidades')->nullable();
            $table->string('type_reduction');
            $table->string('fam0');
            $table->string('fam1');
            $table->unsignedBigInteger('id');
            $table->decimal('volumen', 10, 4);
            $table->integer('stock_disponible');
            $table->date('fecha_limite_unidades_hasta')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
