<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InteriorTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $rows = [
            ['name' => 'Kosongan AC', 'code' => 'kosongan_ac', 'description' => 'Empty with AC', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Kosongan', 'code' => 'kosongan', 'description' => 'Empty unit', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Furnished', 'code' => 'furnished', 'description' => 'Fully furnished', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Semi Furnished', 'code' => 'semi_furnished', 'description' => 'Semi furnished', 'sort_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('interior_types')->insert($rows);
    }
}
