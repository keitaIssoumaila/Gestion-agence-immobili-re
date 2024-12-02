<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAgenceIdToUsersTable extends Migration
{
    /**
     * La méthode pour appliquer la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Ajout de la colonne agence_id
            $table->unsignedBigInteger('agence_id')->nullable();

            // Définir la clé étrangère vers la table agences
            $table->foreign('agence_id')->references('id')->on('agences')->onDelete('set null');
        });
    }

    /**
     * La méthode pour annuler la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Supprimer la clé étrangère et la colonne agence_id
            $table->dropForeign(['agence_id']);
            $table->dropColumn('agence_id');
        });
    }
}
