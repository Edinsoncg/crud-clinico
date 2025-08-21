<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('muestra_biologica', function (Blueprint $table) {
            $table->id();

            $table->string('codigo_muestra', 50)->unique();

            $table->foreignId('paciente_id')
                  ->constrained('paciente')
                  ->restrictOnDelete();

            $table->foreignId('personal_salud_id')
                  ->constrained('personal_salud')
                  ->restrictOnDelete();

            $table->foreignId('tipo_muestra_id')
                  ->constrained('tipo_muestra')
                  ->restrictOnDelete();

            $table->foreignId('estado_muestra_id')
                  ->constrained('estado_muestra')
                  ->restrictOnDelete();

            $table->date('fecha_recoleccion');
            $table->time('hora_recoleccion');
            $table->string('lugar_recoleccion', 150);

            // Si mantienes un campo libre por compatibilidad:
            $table->string('recolectado_por', 100);

            $table->text('observaciones')->nullable();

            $table->index(['fecha_recoleccion', 'codigo_muestra']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('muestra_biologica');
    }
};
