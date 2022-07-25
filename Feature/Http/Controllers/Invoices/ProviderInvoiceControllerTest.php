<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\Brands\Brand;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Inertia\Testing\Assert;

uses()->group('invoices', 'provider-invoice.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->seed(DatabaseSeeder::class);
});

test('renders provider invoices screen', function () {
    $brandsCounter = Brand::count();

    $this->actingAs($this->user)
        ->get('/provider-invoices')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('ProviderInvoices/Index')
                ->has('brands', $brandsCounter)
                ->hasAll([
                    "import_cols",
                    'filters',
                    'number_invoice',
                    'total_htva',
                    'provider_invoices'
                ])
        );
});
