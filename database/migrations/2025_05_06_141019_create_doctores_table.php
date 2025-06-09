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
        Schema::create('doctores', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_documento');
            $table->string('nro_documento')->unique();
            $table->string('nombre');
            $table->string('apepaterno');
            $table->string('apematerno');
            $table->string('telefono');
            $table->date('fechanacimiento');
            $table->string('centrosalud');
            $table->string('especialidad')->nullable();
            $table->string('provincia')->nullable();
            $table->string('distrito')->nullable();
            $table->string('observaciones')->nullable();
            $table->foreignId('evento_id')->constrained(table: 'eventos')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctores');
    }
};
