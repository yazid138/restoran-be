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
        $capacities = [2, 4, 4, 6, 8];

        // Create 20 tables
        for ($i = 1; $i <= 20; $i++) {
            Table::create([
                'table_name' => (string) $i,
                'status' => 'available',
                'capacity' => $capacities[array_rand($capacities)],
            ]);
        }
    }
}
