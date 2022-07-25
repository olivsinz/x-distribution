<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Customers\Customer;
use App\Models\Seasons\Season;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Inertia\Testing\Assert;

uses()->group('reporting', 'reporting.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->seed(DatabaseSeeder::class);
});

test('renders reporting-client-mark screen', function () {
    $customersCounter = Customer::count();
    $usersCounter = User::count();
    $seasonsCounter = Season::count();

    $this->actingAs($this->user)
        ->get('/reporting-client-mark')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Reporting/client-mark')
                ->has('customers', $customersCounter)
                ->has('users', $usersCounter)
                ->has('seasons', $seasonsCounter)
                ->hasAll([
                    'results',
                    'genders',
                    'brands',
                    'countries',
                ])
        );
});

test('renders reporting-commission screen', function () {
    $customersCounter = Customer::count();
    $usersCounter = User::count();
    $seasonsCounter = Season::count();

    $this->actingAs($this->user)
        ->get('/reporting-commission')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Reporting/reporting-commission')
                ->has('customers', $customersCounter)
                ->has('users', $usersCounter)
                ->has('seasons', $seasonsCounter)
                ->hasAll([
                    'years',
                    'genders',
                    'countries',
                    'brands',
                    'shops',
                    'datas',
                ])
        );
});
