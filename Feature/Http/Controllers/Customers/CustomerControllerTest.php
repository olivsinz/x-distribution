<?php

namespace Tests\Feature\Http\Controllers\Customers;

use App\Models\User;
use Inertia\Testing\Assert;

uses()->group('customers', 'customer.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders customers screen', function () {
    $this->actingAs($this->user)
        ->get('/customers')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Customers/Index')
                ->hasAll([
                    'customer_types',
                    'users',
                    'genders',
                    'brands',
                    'countries',
                    // 'years',
                    "import_cols",
                    'filters',
                    'customers'
                ])
        );
});

test('renders create-customer screen', function () {
    $this->actingAs($this->user)
        ->get('/customers/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Customers/Create')
                ->hasAll([
                    'contacts',
                    'shops',
                    'brands',
                    'countries',
                    'contact_types',
                    'customer_types',
                    'users'
                ])
        );
});
