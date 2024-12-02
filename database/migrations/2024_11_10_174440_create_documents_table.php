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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bien_id')->constrained('biens')->onDelete('cascade');  // Clé étrangère vers la table `biens`
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');
            $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade');  // Clé étrangère vers la table `biens`
            $table->string('nom_fichier');
            $table->string('type_document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
