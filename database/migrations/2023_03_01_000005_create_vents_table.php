<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->date('date_vent');
            $table->decimal('prix_vent', 10, 2);
            $table->decimal('prix_achat', 10, 2)->default(0);
            $table->integer('quantite');
            $table->string('local');
            $table->string('paiement');
            $table->string('clientname');
            $table->string('clientadresse');
            $table->string('clientphone');
            $table->string('clientemail');
            $table->string('agent')->nullable();
            $table->string('par')->nullable();
            $table->string('societe')->nullable();
            $table->boolean('livraison')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vents');
    }
};
