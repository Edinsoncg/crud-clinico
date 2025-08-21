<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('paciente', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 120);

            $table->foreignId('tipo_documento_id')
                  ->constrained('tipo_documento')
                  ->restrictOnDelete(); // evita borrar catálogo en uso

            $table->string('numero_documento', 20);
            $table->unique(['tipo_documento_id', 'numero_documento']); // único por tipo

            $table->date('fecha_nacimiento')->nullable();

            $table->foreignId('genero_id')
                  ->nullable()
                  ->constrained('genero')
                  ->nullOnDelete();

            $table->string('telefono', 20)->nullable(); // Teléfono de contacto
            $table->string('direccion', 255)->nullable(); // Dirección de residencia

            $table->index(['apellidos', 'nombres']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('paciente');
    }
};
