<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Simple name-only tables: brands, categories, payment methods, companies.
     */
    private array $tables = ['brands', 'categories', 'mode_de_paiement', 'societes'];

    public function up(): void
    {
        foreach ($this->tables as $name) {
            Schema::create($name, function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        foreach (array_reverse($this->tables) as $name) {
            Schema::dropIfExists($name);
        }
    }
};
