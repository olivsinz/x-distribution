<?php

namespace Tests\Feature\Http\Controllers\Invoices;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Inertia\Testing\Assert;

uses()->group('invoices', 'seller.invoices', 'seller-invoice.controller');

beforeEach(function () {
    $this->user = User::factory()->create(['first_name' => 'John', 'last_name' => 'Doe']);
    $this->seed(DatabaseSeeder::class);
});

test('renders seller invoices screen', function () {
    $this->actingAs($this->user)
        ->get('/seller-invoices')
        ->assertStatus(200)
        ->assertInertia(
            fn (Assert $page) => $page
                ->component('SellerInvoices/Index')
                ->hasAll([
                    'number_invoice',
                    'total_htva',
                    'seller_invoices'
                ])
        );
});
