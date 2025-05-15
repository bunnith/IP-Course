<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create([
            'name' => 'Bun Nith',
            'email' => 'Nith@example.com',
            'phone' => '1234567890'
        ]);

        Customer::create([
            'name' => 'Nay Smith',
            'email' => 'Smith@example.com',
            'phone' => '0987654321'
        ]);
    }
}
