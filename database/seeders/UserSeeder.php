<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Pelayan (Waiters)
        $waiter1 = User::create([
            'name' => 'Budi Pelayan',
            'email' => 'budi@restoran.com',
            'password' => Hash::make('password'),
        ]);
        $waiter1->assignRole('pelayan');

        $waiter2 = User::create([
            'name' => 'Siti Pelayan',
            'email' => 'siti@restoran.com',
            'password' => Hash::make('password'),
        ]);
        $waiter2->assignRole('pelayan');

        // Create Kasir (Cashiers)
        $cashier1 = User::create([
            'name' => 'Andi Kasir',
            'email' => 'andi@restoran.com',
            'password' => Hash::make('password'),
        ]);
        $cashier1->assignRole('kasir');

        $cashier2 = User::create([
            'name' => 'Dewi Kasir',
            'email' => 'dewi@restoran.com',
            'password' => Hash::make('password'),
        ]);
        $cashier2->assignRole('kasir');
    }
}
