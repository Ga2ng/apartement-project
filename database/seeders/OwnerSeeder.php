<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();
        $rows = [
            ['name' => 'BED DEBT', 'code' => 'bed_debt', 'contact_name' => null, 'contact_phone' => null, 'contact_email' => null, 'address' => null, 'notes' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UNSOLD-PPA', 'code' => 'unsold_ppa', 'contact_name' => null, 'contact_phone' => null, 'contact_email' => null, 'address' => null, 'notes' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'UNSOLD-TGA', 'code' => 'unsold_tga', 'contact_name' => null, 'contact_phone' => null, 'contact_email' => null, 'address' => null, 'notes' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'BSG', 'code' => 'bsg', 'contact_name' => null, 'contact_phone' => null, 'contact_email' => null, 'address' => null, 'notes' => null, 'is_active' => true, 'created_at' => $now, 'updated_at' => $now],
        ];
        DB::table('owners')->insert($rows);
    }
}
