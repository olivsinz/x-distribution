<?php

namespace Tests\Feature\Http\Controllers\ShopVisits;

use App\Models\User;
use Inertia\Testing\Assert;

uses()->group('shopvisits', 'shopvisit.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders shopvisits screen', function () {
    $this->actingAs($this->user)
        ->get('/shop-visits')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('ShopVisits/Index')
                ->hasAll([
                    'filters',
                    'seasons',
                    'customers',
                    'creators',
                    'shop_visits',
                ])
        );
});

test('renders create-shopvisit screen', function () {
    $this->actingAs($this->user)
        ->get('/shop-visits/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('ShopVisits/Create')
                ->hasAll([
                    'customers',
                    'seasons',
                    'photo_types',
                    'competitors',
                    'users',
                    'current_competitors',
                    'genders',
                    'brands',
                ])
        );
});
