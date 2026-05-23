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
        Schema::connection('mysql2')->create('productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre');
            $table->decimal('dosis', 10,2)->nullable();
            $table->decimal('valor_unitario', 10,2)->nullable();
            $table->integer('codigo');
            $table->string('categoria');
            $table->integer('id_unidad_medida')->unsigned();
            $table->integer('id_tipo_producto')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_unidad_medida')->references('id')->on('unidad_medida');
            $table->foreign('id_tipo_producto')->references('id')->on('tipo_producto');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('productos');
    }
};
