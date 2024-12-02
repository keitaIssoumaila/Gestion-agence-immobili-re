<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('locataire_id')->constrained('locataires')->onDelete('cascade');  // Clé étrangère vers la table `locataires`
            $table->foreignId('bien_id')->constrained('biens')->onDelete('cascade');  // Clé étrangère vers la table `biens`
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');
            $table->date('date_reservation'); 
            $table->enum('status', ['en_attente', 'confirmée', 'annulée'])->default('en_attente');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
