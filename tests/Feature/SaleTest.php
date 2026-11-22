<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Vent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class SaleTest extends TestCase
{
    use RefreshDatabase;

    private int $productId;

    protected function setUp(): void
    {
        parent::setUp();

        $now = now();
        $brand = DB::table('brands')->insertGetId(['name' => 'Samsung', 'created_at' => $now, 'updated_at' => $now]);
        $categorie = DB::table('categories')->insertGetId(['name' => 'Phones', 'created_at' => $now, 'updated_at' => $now]);
        DB::table('mode_de_paiement')->insert(['name' => 'Cash', 'created_at' => $now, 'updated_at' => $now]);

        $this->productId = DB::table('products')->insertGetId([
            'name' => 'Galaxy S23',
            'brand_id' => $brand,
            'categorie_id' => $categorie,
            'prix_vente' => 8000,
            'quantite' => 10,
            'quantite_marrakech' => 6,
            'quantite_rabat' => 4,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('achats')->insert([
            'product_id' => $this->productId,
            'prix_achat' => 6500,
            'quantite' => 10,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }

    private function sale(array $overrides = []): array
    {
        return array_merge([
            'product' => $this->productId,
            'prix_vent' => 8000,
            'quantite' => 2,
            'paiement' => 'Cash',
            'local' => 'Rabat',
            'clientname' => 'Client',
            'clientadresse' => 'Somewhere',
            'clientphone' => '0600000000',
            'clientemail' => 'client@example.com',
        ], $overrides);
    }

    private function stock(): object
    {
        return DB::table('products')->find($this->productId);
    }

    public function test_sale_form_offers_the_two_stores(): void
    {
        $this->actingAs(User::factory()->create(['local' => 'Rabat']))
            ->get('/vent/create')
            ->assertOk()
            ->assertSee('<option value="Rabat" selected', false)
            ->assertSee('<option value="Marrakech"', false);
    }

    public function test_recording_a_sale_uses_the_purchase_price_from_the_database(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post('/vent', $this->sale(['prix_achat' => 1]))
            ->assertRedirect('/dashboard');

        $vent = Vent::sole();
        $this->assertSame($user->id, $vent->user_id);
        $this->assertEquals(6500, $vent->prix_achat);
    }

    public function test_recording_a_sale_decrements_stock_for_that_location(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/vent', $this->sale(['quantite' => 3, 'local' => 'Rabat']))
            ->assertRedirect('/dashboard');

        $this->assertSame(7, (int) $this->stock()->quantite);
        $this->assertSame(1, (int) $this->stock()->quantite_rabat);
        $this->assertSame(6, (int) $this->stock()->quantite_marrakech);
    }

    public function test_cannot_sell_more_than_the_location_has_in_stock(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/vent', $this->sale(['quantite' => 5, 'local' => 'Rabat']))
            ->assertSessionHasErrors('quantite');

        $this->assertSame(0, Vent::count());
        $this->assertSame(4, (int) $this->stock()->quantite_rabat);
    }

    public function test_location_must_be_a_known_store(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/vent', $this->sale(['local' => 'Casablanca']))
            ->assertSessionHasErrors('local');

        $this->assertSame(0, Vent::count());
    }

    public function test_deleting_a_sale_puts_the_stock_back(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/vent', $this->sale(['quantite' => 3, 'local' => 'Marrakech']));

        $this->actingAs($user)->delete('/vent/'.Vent::sole()->id)->assertRedirect('/dashboard');

        $this->assertSame(10, (int) $this->stock()->quantite);
        $this->assertSame(6, (int) $this->stock()->quantite_marrakech);
    }

    public function test_user_cannot_delete_another_users_sale(): void
    {
        $owner = User::factory()->create();
        $this->actingAs($owner)->post('/vent', $this->sale());
        $vent = Vent::sole();

        $this->actingAs(User::factory()->create())
            ->delete("/vent/{$vent->id}")
            ->assertNotFound();

        $this->assertModelExists($vent);
    }

    public function test_dashboard_profit_counts_only_this_months_sales(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user)->post('/vent', $this->sale(['quantite' => 1, 'prix_vent' => 8000]));
        $this->actingAs($user)->post('/vent', $this->sale(['quantite' => 1, 'prix_vent' => 9000]));

        // A sale from last month must not count.
        Vent::query()->latest('id')->first()->replicate()->fill([])->forceFill([
            'date_vent' => now()->subMonthNoOverflow()->startOfMonth()->format('Y-m-d'),
            'prix_vent' => 99999,
        ])->save();

        $this->actingAs($user)->get('/dashboard')
            ->assertOk()
            ->assertViewHas('total_prix_vent', fn ($v) => (float) $v === 17000.0)
            ->assertViewHas('total_profit', fn ($v) => (float) $v === 4000.0);
    }
}
