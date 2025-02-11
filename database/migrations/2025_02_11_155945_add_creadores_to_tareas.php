<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
    Schema::table('tareas', function (Blueprint $table) {
        // Agregar la columna creador_id y hacer que no pueda ser nula
        $table->unsignedBigInteger('creador_id');

        // Definir la clave foránea y usar 'cascade' para eliminar en cascada
        $table->foreign('creador_id')
              ->references('id')->on('users')
              ->onDelete('cascade');  // Elimina las tareas relacionadas si el creador es eliminado
        });
    }

    /**
     * Reverse the migrations.
     */
     public function down()
    {
    Schema::table('tareas', function (Blueprint $table) {
        $table->dropForeign(['creador_id']);  // Eliminar la clave foránea
        $table->dropColumn('creador_id');     // Eliminar la columna creador_id
    });
    }
};
