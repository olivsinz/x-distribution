<?php

namespace Tests\Feature\Http\Controllers\Sellouts;

use App\Models\User;
use Inertia\Testing\Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

uses()->group('sellouts', 'sellout.controller');

test('renders sellouts screen', function () {
    $user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->actingAs($user)
        ->get('/sellouts')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Sellout/Index')
                ->hasAll([
                    'sellouts',
                    'users',
                    'shops',
                    'brands',
                    'seasons',
                    'genders',
                ])
        );
});

test('renders create-sellout screen', function () {
    $user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->actingAs($user)
        ->get('/sellouts/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Sellout/Create')
                ->hasAll([
                    'customers',
                    'seasons',
                    'genders',
                    'shops',
                    'users',
                    'brands',
                ])
        );
});
