<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('cargo', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 80)->unique();
            $table->string('abreviatura', 10)->nullable()->unique();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cargo');
    }
};
