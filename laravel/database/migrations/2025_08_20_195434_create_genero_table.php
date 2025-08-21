<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('genero', function (Blueprint $table) {
            $table->id(); // unsigned BIGINT por defecto
            // Nombre legible: Masculino, Femenino, No Binario, Otro...
            $table->string('nombre', 50)->unique();
            // Abreviacion corto para integraciones: M, F, O, NB, etc.
            $table->string('abreviacion', 5)->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('genero');
    }
};
