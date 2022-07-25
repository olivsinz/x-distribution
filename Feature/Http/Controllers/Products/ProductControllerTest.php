<?php

namespace Tests\Feature\Http\Controllers\Products;

use App\Models\Products\Product;
use App\Models\Seasons\Season;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Inertia\Testing\Assert;

uses()->group('products', 'product.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->seed(DatabaseSeeder::class);
});

test('renders products screen', function () {
    $this->actingAs($this->user)
        ->get('/products')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Products/Index')
                ->has('products')
                ->hasAll([
                    "import_cols",
                    'filters',
                    'brands',
                ])
        );
});

test('renders create-product screen', function () {
    $seasonsCount = Season::count();

    $this->actingAs($this->user)
        ->get('/products/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Products/Create')
                ->has('seasons', $seasonsCount)
                ->hasAll([
                    'product_sizes',
                    'product_size_categories',
                    'seasons',
                    'brands',
                    'product_families',
                    'stock_locations',
                ])
        );
});
