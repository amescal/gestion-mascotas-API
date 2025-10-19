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
        Schema::create('mascotas', function (Blueprint $table) {
            $table->id();
            // Cada mascota pertenece a un usuario, si se borra el usuario o se actualiza su id, se actualiza en cascada
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')
                ->on('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('nombre', 50);
            $table->string('descripcion', 250);
            $table->enum('tipo', ['Perro','Gato','Pájaro','Dragón','Conejo','Hamster','Tortuga','Pez','Serpiente']);
            $table->enum('publica', ['Si','No']);
            //se usa unsignedInteger para que contenga solo valores enteros positivos, por defecto es 0
            $table->unsignedInteger('megusta')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mascotas');
    }
};
