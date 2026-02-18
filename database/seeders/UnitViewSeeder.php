<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitViewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $rows = [
            ['name' => 'Sea', 'code' => 'sea', 'description' => 'Sea view', 'sort_order' => 1, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Pool', 'code' => 'pool', 'description' => 'Pool view', 'sort_order' => 2, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Mountain', 'code' => 'mountain', 'description' => 'Mountain view', 'sort_order' => 3, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sky Garden', 'code' => 'sky_garden', 'description' => 'Sky garden view', 'sort_order' => 4, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'City', 'code' => 'city', 'description' => 'City view', 'sort_order' => 5, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Garden Sea', 'code' => 'garden_sea', 'description' => 'Garden and sea view', 'sort_order' => 6, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('unit_views')->insert($rows);
    }
}
