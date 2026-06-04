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
    // vérifier AVANT Schema::table
    if (Schema::hasColumn('notes', 'matiere')) {

        Schema::table('notes', function (Blueprint $table) {
            // supprimer ancienne colonne
            $table->dropColumn('matiere');
        });
    }

    // ajouter matiere_id seulement si elle n'existe pas
    if (!Schema::hasColumn('notes', 'matiere_id')) {

        Schema::table('notes', function (Blueprint $table) {
            // ajouter clé étrangère vers matieres
            $table->foreignId('matiere_id')
                  ->constrained()
                  ->onDelete('cascade');
        });
    }
}
public function down()
{
    Schema::table('notes', function (Blueprint $table) {
        // remettre ancienne colonne si rollback
        $table->string('matiere');
        // supprimer matiere_id
        $table->dropForeign(['matiere_id']);
        $table->dropColumn('matiere_id');
    });
}
};
