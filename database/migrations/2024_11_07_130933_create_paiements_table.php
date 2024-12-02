<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaiementsTable extends Migration
{
    public function up()
    {
        Schema::create('paiements', function (Blueprint $table) {
            $table->id();
            $table->decimal('montant', 10, 2);
            $table->date('date_paiement');
            $table->enum('status', ['en_attente', 'effectué', 'annulé'])->default('en_attente');
            $table->foreignId('contrat_id')->constrained('contrats')->onDelete('cascade');  // Clé étrangère vers la table `contrats`
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paiements');
    }
}
