<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image')->nullable();
            $table->foreignId('categorie_id')->constrained('categories');
            $table->foreignId('brand_id')->constrained('brands');
            $table->decimal('prix_vente', 10, 2)->default(0);
            $table->decimal('prix_promo', 10, 2)->nullable();
            $table->decimal('prix_revendeur', 10, 2)->nullable();
            $table->integer('quantite')->default(0);
            $table->integer('quantite_marrakech')->default(0);
            $table->integer('quantite_rabat')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
