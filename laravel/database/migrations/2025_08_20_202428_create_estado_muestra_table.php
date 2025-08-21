<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('estado_muestra', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60)->unique(); // Pendiente, En análisis, Procesada, Rechazada
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_muestra');
    }
};
