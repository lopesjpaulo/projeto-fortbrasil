<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEstabelecimentoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estabelecimento', function (Blueprint $table) {
            $table->bigIncrements('estabelecimento_id');
            $table->string('nome', 255);
            $table->string('cep', 9);
            $table->string('logradouro', 255);
            $table->string('numero', 5);
            $table->string('bairro', 100);
            $table->string('cidade', 100);
            $table->string('estado', 2);
            $table->text('complemento')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('estabelecimento');
    }
}
