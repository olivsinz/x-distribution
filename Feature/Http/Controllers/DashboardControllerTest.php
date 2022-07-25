<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Inertia\Testing\Assert;

uses()->group('dashboard', 'dashboard.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('renders dashboard-list screen', function () {
    $this->actingAs($this->user)
        ->get('/dashboard-list')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('Dashboard/index')
                ->hasAll([
                    'seasons',
                    'shops',
                ])
        );
});
