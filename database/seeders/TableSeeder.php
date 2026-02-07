<?php

namespace Database\Seeders;

use App\Models\Table;
use Illuminate\Database\Seeder;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = ['available', 'available', 'available', 'occupied', 'reserved'];
        $capacities = [2, 4, 4, 6, 8];

        // Create 20 tables
        for ($i = 1; $i <= 20; $i++) {
            Table::create([
                'table_number' => (string) $i,
                'status' => $statuses[array_rand($statuses)],
                'capacity' => $capacities[array_rand($capacities)],
            ]);
        }
    }
}
