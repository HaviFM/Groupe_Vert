<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Recréer la table roles si elle n'existe pas
        if (!Schema::hasTable('roles')) {
            Schema::create('roles', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // Admin, Utilisateur, etc.
                $table->timestamps();
            });
    
            // Insérer les rôles de base
            DB::table('roles')->insert([
                ['id' => 1, 'name' => 'Utilisateur', 'created_at' => now(), 'updated_at' => now()],
                ['id' => 2, 'name' => 'Admin', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    
        // Ajouter les colonnes manquantes à la table users
        Schema::table('users', function (Blueprint $table) {
            // Ajouter role_id avec une clé étrangère pointant vers la table roles
            if (!Schema::hasColumn('users', 'role_id')) {
                $table->unsignedBigInteger('role_id')->nullable();
                $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            }
    
            // Ajouter la colonne statut pour suivre le statut des utilisateurs
            if (!Schema::hasColumn('users', 'statut')) {
                $table->string('statut')->default('en_attente');
            }
        });
    }
    
    public function down()
    {
        // Supprimer les colonnes ajoutées si on annule la migration
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'role_id')) {
                $table->dropForeign(['role_id']);
                $table->dropColumn('role_id');
            }
    
            if (Schema::hasColumn('users', 'statut')) {
                $table->dropColumn('statut');
            }
        });
    
        // Supprimer la table roles si on annule la migration
        if (Schema::hasTable('roles')) {
            Schema::dropIfExists('roles');
        }
    }
    
};
