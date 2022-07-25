<?php

namespace Tests\Feature\Http\Controllers\Orders;

use App\Models\User;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

uses()->group('orders', 'order.controller');

test('renders orders screen', function () {
    $user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->actingAs($user)
        ->get('/orders')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Orders/Index')
                ->hasAll([
                    'genders',
                    'countries',
                    'users',
                    'brands',
                    'seasons',
                    'years',
                    'collection_types',
                    'import_cols',
                    'filters',
                    'delivery_total_qte',
                    'total_order',
                    'delivery_total_htva',
                    'confirmation_total_qte',
                    'confirmation_total_htva',
                    'order_average_price',
                    'order_total_qte',
                    'order_total_htva'
                ])
                ->has('orders')
                ->has('total_order')
        );
});

test('renders create-order screen', function () {
    $user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->actingAs($user)
        ->get('/orders/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Orders/Create')
                ->hasAll([
                    'collection_types',
                    'seasons',
                    'genders',
                    'countries',
                    'users',
                    'products',
                    'cancellations',
                ])
        );
});
