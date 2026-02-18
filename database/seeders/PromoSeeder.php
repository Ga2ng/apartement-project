<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $rows = [
            [
                'code' => 'EARLY10',
                'name' => 'Early Bird 10%',
                'description' => '10% off for bookings 7+ days in advance',
                'type' => 'percentage',
                'value' => 10,
                'min_stay_nights' => 1,
                'min_amount' => null,
                'valid_from' => now()->startOfYear(),
                'valid_until' => now()->endOfYear()->addYear(),
                'max_uses' => null,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'code' => 'WEEKEND50K',
                'name' => 'Weekend Fixed',
                'description' => 'Rp 50.000 off for weekend stays',
                'type' => 'fixed_amount',
                'value' => 50000,
                'min_stay_nights' => 2,
                'min_amount' => 200000,
                'valid_from' => now()->startOfYear(),
                'valid_until' => now()->endOfYear()->addYear(),
                'max_uses' => 100,
                'used_count' => 0,
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];
        DB::table('promos')->insert($rows);
    }
}
