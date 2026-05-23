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
        Schema::connection('mysql2')->create('ingrediente_activo_x_product', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_producto')->unsigned()->nullable();
            $table->integer('id_ingredient_activ')->unsigned()->nullable();
            $table->integer('id_user')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_ingredient_activ')->references('id')->on('ingrediente_activo');
            $table->foreign('id_producto')->references('id')->on('productos');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('ingrediente_activo_x_product');
    }
};
