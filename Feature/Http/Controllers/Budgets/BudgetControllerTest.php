<?php

namespace Tests\Feature\Http\Controllers\Budgets;

use App\Models\Budgets\Budget;
use App\Models\User;
use Database\Seeders\BudgetSeeder;
use Illuminate\Testing\Fluent\AssertableJson;
use Inertia\Testing\Assert;
use function Pest\Laravel\getJson;

uses()->group('budgets', 'budget.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders budgets screen', function () {
    $this->actingAs($this->user)
        ->get('/budgets')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Budgets/Index')
                ->hasAll([
                    'filters',
                    'seasons',
                    'shops',
                    'users',
                    'countries',
                    'genders',
                    'years',
                ])
        );
});

test('renders create-budget screen', function () {
    $this->actingAs($this->user)
        ->get('/budgets/create')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Budgets/Create')
                ->hasAll([
                    'seasons',
                    'countries',
                    'genders',
                    'brands',
                ])
        );
});

test('fetch budgets from db', function () {
    Budget::factory()->count(5)->create();
    $response = $this->actingAs($this->user)->getJson('budget-fetch');
    $response
        ->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) =>
            $json
                ->has('datas')
                ->has('parts')
                ->has('total_ht')
        );;
});
