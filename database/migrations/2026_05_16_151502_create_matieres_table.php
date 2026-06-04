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
    Schema::create('matieres', function (Blueprint $table) {
        $table->id();
    
        $table->string('nom');
        $table->integer('coefficient');
    
        // clé étrangère
        $table->foreignId('classe_id')->constrained()->onDelete('cascade');
    
        // UNIQUE doit venir après
        $table->unique(['nom', 'classe_id']);
    
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matieres');
    }
};
