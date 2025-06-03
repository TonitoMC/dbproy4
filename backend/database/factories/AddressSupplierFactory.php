<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AddressSupplier>
 */
class AddressSupplierFactory extends Factory
{
    public function definition(): array
    {
        return [
            'address_id' => Address::factory(),
            'supplier_id' => Supplier::factory(),
        ];
    }
}
