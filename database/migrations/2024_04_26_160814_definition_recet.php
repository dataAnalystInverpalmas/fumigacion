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
        Schema::connection('mysql2')->create('definicion_receta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tipo_aplicacion')->unsigned();
            $table->integer('id_user')->unsigned();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_tipo_aplicacion')->references('id')->on('tipo_aplicacion');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mysql2')->dropIfExists('definicion_receta');

    }
};
