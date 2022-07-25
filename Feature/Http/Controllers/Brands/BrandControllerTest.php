<?php

namespace Tests\Feature\Http\Controllers\Brands;

use App\Models\User;
use Inertia\Testing\Assert;

uses()->group('brands', 'brand.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders brands screen', function () {
    $this->actingAs($this->user)
        ->get('/brands')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Brands/Index')
                ->hasAll([
                    'import_cols',
                    'filters',
                    'brands'
                ])
        );
});

test('renders create-brand screen', function () {
    $this->actingAs($this->user)
        ->get('/brands/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Brands/Create')
                ->hasAll([
                    'contacts',
                ])
        );
});
