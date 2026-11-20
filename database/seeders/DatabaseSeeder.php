<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed demo data so the app can be tried right after `php artisan migrate --seed`.
     */
    public function run(): void
    {
        $now = now();

        foreach (['Samsung', 'Apple', 'Xiaomi'] as $name) {
            DB::table('brands')->insert(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        }
        foreach (['Téléphones', 'Accessoires'] as $name) {
            DB::table('categories')->insert(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        }
        foreach (['Espèces', 'Carte bancaire', 'Virement'] as $name) {
            DB::table('mode_de_paiement')->insert(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        }
        foreach (['Société A', 'Société B'] as $name) {
            DB::table('societes')->insert(['name' => $name, 'created_at' => $now, 'updated_at' => $now]);
        }

        $products = [
            ['Galaxy S23', 1, 1, 8000, 6500],
            ['iPhone 14', 2, 1, 10000, 8500],
            ['Redmi Note 12', 3, 1, 2500, 1900],
            ['Chargeur USB-C', 1, 2, 150, 80],
        ];
        foreach ($products as [$name, $brand, $categorie, $prixVente, $prixAchat]) {
            $id = DB::table('products')->insertGetId([
                'name' => $name,
                'brand_id' => $brand,
                'categorie_id' => $categorie,
                'prix_vente' => $prixVente,
                'quantite' => 10,
                'quantite_marrakech' => 5,
                'quantite_rabat' => 5,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('achats')->insert([
                'product_id' => $id,
                'prix_achat' => $prixAchat,
                'quantite' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        User::create([
            'name' => 'Demo',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'local' => 'Marrakech',
        ]);
    }
}
