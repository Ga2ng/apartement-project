<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $rows = [
            ['name' => 'Studio', 'code' => 'studio', 'description' => 'Studio unit', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '2BR', 'code' => '2br', 'description' => '2 bedroom', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => '3BR', 'code' => '3br', 'description' => '3 bedroom', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('unit_types')->insert($rows);
    }
}
