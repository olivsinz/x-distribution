<?php

namespace Tests\Feature\Http\Controllers\Shops;

use App\Models\Shops\Shop;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Database\Seeders\ShopSeeder;
use Inertia\Testing\Assert;

uses()->group('shops', 'shop.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders customers screen', function () {
    $this->actingAs($this->user)
        ->get('/shops')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Shops/Index')
                ->hasAll([
                    "import_cols",
                    'filters',
                    'shops'
                ])
        );
});

test('renders create-customer screen', function () {
    $this->actingAs($this->user)
        ->get('/shops/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Shops/Create')
                ->hasAll([
                    'customers',
                    'contacts',
                    'competitors',
                    'countries',
                    'contact_types',
                ])
        );
});

test('renders edit-customer screen', function () {
    $this->seed(DatabaseSeeder::class);

    $shop = Shop::first();
    $this->actingAs($this->user)
        ->get('/shops/' . $shop->id . '/edit')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Shops/Edit')
                ->hasAll([
                    'shop',
                    'customers',
                    'contacts',
                    'competitors',
                    'countries',
                    'shop_has_contacts',
                    'shop_has_competitors',
                    'contact_types',
                    'files',
                    'customer',
                    'shop_country'
                ])
        );
});
