<?php

namespace Tests\Feature\Http\Controllers\Api\Customers;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Testing\Fluent\AssertableJson;

uses()->group('api', 'api.customers', 'customers', 'api.customer.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
});

test('gets all customers with brands', function () {
    $this->seed(DatabaseSeeder::class);

    $this->actingAs($this->user, 'api')
        ->get('/api/customers-with-brands')
        ->assertStatus(200)
        ->assertJson(
            fn (AssertableJson $json) => $json->has('data')
        );
});
