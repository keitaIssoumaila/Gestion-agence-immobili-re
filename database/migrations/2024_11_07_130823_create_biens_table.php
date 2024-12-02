<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBiensTable extends Migration
{
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('type');  // Exemple : appartement, maison
            $table->string('adresse');
            $table->float('surface')->nullable(); // Surface en m²
            $table->decimal('prix', 10, 2);  // Prix du bien
            $table->enum('status', ['disponible', 'loué', 'réservé'])->default('disponible');
            $table->text('description')->nullable();
            $table->foreignId('agence_id')->constrained()->onDelete('cascade');  // Clé étrangère vers la table `agences`
            $table->foreignId('proprietaire_id')->constrained()->onDelete('cascade');  // Clé étrangère vers la table `proprietaires`
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('biens');
    }
}
