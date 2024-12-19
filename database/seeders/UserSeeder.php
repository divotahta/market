<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Create Admin
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'phone' => '081234567890',
            'address' => 'Jl. Admin No. 1',
            'role' => '1',
            'email_verified_at' => now(),
        ]);

        // Create Sample Customers
        $customers = [
            [
                'name' => 'Natasya',
                'email' => 'natasya@gmail.com',
                'password' => Hash::make('natasya'),
                'phone' => '081234567891',
                'address' => 'Jl. Natasya No. 1',
                'role' => '2',
                'email_verified_at' => now(),
            ]
        ];

        foreach ($customers as $customer) {
            User::create($customer);
        }

        // Create Random Customers
        User::factory()->count(0)->create([
            'role' => '2',
            'email_verified_at' => now(),
        ]);
    }
} 