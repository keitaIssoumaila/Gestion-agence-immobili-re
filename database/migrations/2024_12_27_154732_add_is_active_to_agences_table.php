<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsActiveToAgencesTable extends Migration
{
    /**
     * Exécuter la migration.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('agences', function (Blueprint $table) {
            // Ajoute la colonne is_active avec une valeur par défaut de true (activée)
            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Revenir sur la migration.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('agences', function (Blueprint $table) {
            // Supprime la colonne is_active si nécessaire
            $table->dropColumn('is_active');
        });
    }
}
