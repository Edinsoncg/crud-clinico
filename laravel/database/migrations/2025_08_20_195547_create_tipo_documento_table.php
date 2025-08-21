<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();    // Cédula de ciudadanía, etc.
            $table->string('abreviatura', 10)->unique();    // CC, TI, CE, PAS...
            $table->unsignedTinyInteger('longitud_min')->default(5);
            $table->unsignedTinyInteger('longitud_max')->default(20);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('tipo_documento');
    }
};
