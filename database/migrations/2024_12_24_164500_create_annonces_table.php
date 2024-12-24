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
        Schema::create('annonces', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['perdu', 'retrouvé']);
            $table->foreignId('categorie_id')->constrained()->onDelete('cascade');
            $table->string('titre');
            $table->text('description');
            $table->string('images')->nullable(); // Stocker les chemins des images
            $table->date('date');
            $table->string('lieu');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('statut', ['active', 'résolue', 'en attente'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('annonces');
    }
};
