<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('personal_salud', function (Blueprint $table) {
            $table->id();
            $table->string('nombres', 100);
            $table->string('apellidos', 120);

            $table->foreignId('cargo_id')
                  ->constrained('cargo')
                  ->restrictOnDelete();

            $table->foreignId('tipo_documento_id')
                  ->constrained('tipo_documento')
                  ->restrictOnDelete();

            $table->string('numero_documento', 20);
            $table->unique(['tipo_documento_id', 'numero_documento']);

            $table->string('telefono', 20)->nullable(); // Teléfono de contacto
            $table->string('direccion', 255)->nullable(); // Dirección de residencia

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_salud');
    }
};
