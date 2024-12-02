<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContratsTable extends Migration
{
    public function up()
    {
        Schema::create('contrats', function (Blueprint $table) {
            $table->id();
            $table->date('date_debut');
            $table->date('date_fin')->nullable();
            $table->decimal('montant', 10, 2);
            $table->longText('description');
            $table->foreignId('locataire_id')->constrained('locataires')->onDelete('cascade');  // Clé étrangère vers la table `locataires`
            $table->foreignId('bien_id')->constrained('biens')->onDelete('cascade');  // Clé étrangère vers la table `biens`
            $table->foreignId('agence_id')->constrained('agences')->onDelete('cascade');  // Clé étrangère vers la table `agences`
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contrats');
    }
}
