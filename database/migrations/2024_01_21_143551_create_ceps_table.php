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
        Schema::create('cep', function (Blueprint $table) {
            //$table->id();
            $table->increments('id');

            $table->string('cep', 8)->unique();
            $table->string('logradouro', 255);
            $table->string('complemento', 255)->nullable();
            $table->string('bairro', 255);
            $table->string('cidade', 255);
            $table->string('uf', 2);
            $table->string('ibge', 10)->nullable();
            $table->string('gia', 10)->nullable();
            $table->string('ddd', 2)->nullable();
            $table->string('siafi', 10)->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cep');
    }
};
